<?php
/*
V4.65 22 July 2005  (c) 2000-2005 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license.
  Whenever there is any discrepancy between the two licenses,
  the BSD license will take precedence. See License.txt.
  Set tabs to 4 for best viewing.

  Latest version is available at http://adodb.sourceforge.net

  Library for basic performance monitoring and tuning.

  My apologies if you see code mixed with presentation. The presentation suits
  my needs. If you want to separate code from presentation, be my guest. Patches
  are welcome.

  Modified 17 March 2006 for use with ADOdb Lite by Pádraic Brady
  Such modifications (c) 2006 Pádraic Brady (maugrimtr@hotmail.com)

*/

if (!defined(ADODB_DIR)) include_once(dirname(__FILE__).'/adodb.inc.php');
include_once(ADODB_DIR . '/tohtml.inc.php');

define( 'ADODB_OPT_HIGH', 2);
define( 'ADODB_OPT_LOW', 1);

// returns in K the memory of current process, or 0 if not known
function adodb_getmem()
{
    if (function_exists('memory_get_usage'))
        return (integer) ((memory_get_usage()+512)/1024);

    $pid = getmypid();

    if ( strncmp(strtoupper(PHP_OS),'WIN',3)==0) {
        $output = array();

        exec('tasklist /FI "PID eq ' . $pid. '" /FO LIST', $output);
        return substr($output[5], strpos($output[5], ':') + 1);
    }

    /* Hopefully UNIX */
    exec("ps --pid $pid --no-headers -o%mem,size", $output);
    if (sizeof($output) == 0) return 0;

    $memarr = explode(' ',$output[0]);
    if (sizeof($memarr)>=2) return (integer) $memarr[1];

    return 0;
}

// avoids localization problems where , is used instead of .
function adodb_round($n,$prec)
{
    return number_format($n, $prec, '.', '');
}

/* return microtime value as a float */
function adodb_microtime()
{
    $t = microtime();
    $t = explode(' ',$t);
    return (float)$t[1]+ (float)$t[0];
}

/* sql code timing */
function& adodb_log_sql(&$conn,$sql,$inputarr)
{
    /**
     OXID changes - create separate mysql connection for logging for not loosing info from last query (R)
    */
    if(isset($_SESSION['debugPHP']) && is_string($_SESSION['debugPHP']) && isset($_SESSION['debugPHPSearch']) && !empty($_SESSION['debugPHPSearch']))
    {
        $sIdent = $_SESSION['debugPHP'];
    }
    else
    {
        $sIdent = false;
    }

    $_logSqlDbInstance = $conn->_logSqlDbInstance;
    $perf_table = 'adodb_debugphp_logsql';
    $conn->_logsql = false; // replaces setting ::fnExecute=false in ADOdb
    $t0 = microtime();
    $rs =& $conn->Execute($sql,$inputarr);
    $t1 = microtime();
    $conn->_logsql = true; // reverse setting ::_logsql=false

    if (!$_logSqlDbInstance){
        $myConfig  = oxConfig::getInstance();
        $conn->_logSqlDbInstance = $_logSqlDbInstance = & NewADOConnection($myConfig->getConfigParam( "dbType" ));
        $_logSqlDbInstance->_connect($conn->host, $conn->username, $conn->password, $conn->database, false, true);
    }


    if (!empty($conn->_logsql) && $sIdent != false) {
        $bResult = false;
        $aFilter = explode('#', oxSession::getVar( 'debugPHPSearch' ));
        foreach ($aFilter as $sFilter)
        {
            if(strpos(strtolower(trim($sql)), $sFilter) !== false)
            {
               $bResult = true;
            }
        }
        if($bResult === false)
        {
            return $rs;
        }
    //if (!empty($conn->_logsql)) {
        //$conn->_logsql = false; // disable logsql error simulation
        $dbT = $conn->dbtype;

        $a0 = explode (' ',$t0);
        $a0 = (float)$a0[1]+(float)$a0[0];

        $a1 = explode (' ',$t1);
        $a1 = (float)$a1[1]+(float)$a1[0];

        $time = $a1 - $a0;

        if (!$rs) {
            $errM = $conn->ErrorMsg();
            $errN = $conn->ErrorNo();
            $tracer = substr('ERROR: '.htmlspecialchars($errM),0,250);
        } else {
            $tracer = '';
            $errM = '';
            $errN = 0;
        }
        if(isset($_SERVER['HTTP_HOST']))
        {
            $tracer .= $_SERVER['HTTP_HOST'];
            if(isset($_SERVER['PHP_SELF']))
            {
                $tracer .= $_SERVER['PHP_SELF'];
            }
        }
        elseif(isset($_SERVER['PHP_SELF']))
        {
            $tracer .= $_SERVER['PHP_SELF'];
        }
        if(strpos($tracer, "debugax/www/index.php") !== false)
        {
            return $rs;
        }
        // OXID - added backtrace
        $_aTrace = debug_backtrace();
        $_sTrace = '';
        foreach ($_aTrace as $_trace) {
            $_sTrace .= "{$_trace['file']} - {$_trace['function']}:{$_trace['line']} \n";
        }

        $tracer .= "\n\nBacktrace:\n" . $_sTrace;


        $tracer = (string) substr($tracer,0,5000);

        if(is_array($inputarr))
        {
            if(is_array(reset($inputarr)))
            {
                $params = 'Array sizeof=' . sizeof($inputarr);
            }
            else
            {
                // Quote string parameters so we can see them in the
                // performance stats. This helps spot disabled indexes.
                $xar_params = $inputarr;
                foreach($xar_params as $xar_param_key => $xar_param)
                {
                    if (gettype($xar_param) == 'string')
                    $xar_params[$xar_param_key] = '"' . $xar_param . '"';
                }
                $params = implode(', ', $xar_params);
                if (strlen($params) >= 3000) $params = substr($params, 0, 3000);
            }
        }
        else
        {
            $params = '';
        }

        if (is_array($sql)) $sql = $sql[0];
        $arr = array('b'=>strlen($sql).'.'.crc32($sql),
                    'c'=>substr($sql,0,3900), 'd'=> json_encode($rs->fields),'e'=>$tracer,'f'=>adodb_round($time,6));

        $d = $conn->sysTimeStamp;
        if (empty($d))
        {
            $d = date("'Y-m-d H:i:s'");
        }
            $isql = "insert into $perf_table (created,sql0,sql1,params,tracer,timer,type, ident) values( $d,?,?,?,?,?,'sql','$sIdent')";

        try {
            $ok = $_logSqlDbInstance->Execute($isql,$arr);
        } catch (Exception $e) {
            $ok = false;
        }
        if ($ok) {
        } else {
            $err2 = $_logSqlDbInstance->ErrorMsg();
            $perf =& NewPerfMonitor($_logSqlDbInstance);
            if ($perf) {
                if ($perf->CreateLogTable()) $ok = $_logSqlDbInstance->Execute($isql,$arr);
            } else {
                $ok = $_logSqlDbInstance->Execute("CREATE TABLE IF NOT EXISTS `adodb_debugphp_logsql` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `created` datetime NOT NULL,
                  `sql0` varchar(250) COLLATE latin1_general_ci NOT NULL,
                  `sql1` text COLLATE latin1_general_ci NOT NULL,
                  `params` text COLLATE latin1_general_ci NOT NULL,
                  `tracer` text COLLATE latin1_general_ci NOT NULL,
                  `timer` decimal(16,6) NOT NULL,
                  `type` char(50) COLLATE latin1_general_ci NOT NULL,
                  `ident` char(50) COLLATE latin1_general_ci NOT NULL,
                  PRIMARY KEY (`id`),
                  KEY `created` (`created`),
                  KEY `ident` (`ident`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;"
                );
            }
        }
    }

    return $rs;
}


/*
The settings data structure is an associative array that database parameter per element.

Each database parameter element in the array is itself an array consisting of:

0: category code, used to group related db parameters
1: either
    a. sql string to retrieve value, eg. "select value from v\$parameter where name='db_block_size'",
    b. array holding sql string and field to look for, e.g. array('show variables','table_cache'),
    c. a string prefixed by =, then a PHP method of the class is invoked,
        e.g. to invoke $this->GetIndexValue(), set this array element to '=GetIndexValue',
2: description of the database parameter
*/

class adodb_perf {

    function adodb_perf() {}

    /**
     * Alias for perfmon_parent_ADOConnection::table()
     *
     * @access public
     * @param string $newtable The name for the table to use; optional.
     * @return string
     */
    static function table($newtable = false) {
        $rt = perfmon_parent_ADOConnection::table($newtable);
        return $rt;
    }

 }

?>
