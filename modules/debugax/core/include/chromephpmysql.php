<?php



class chromephpMySql extends chromephp
{

    protected function _writeHeader($data)
    {
    	$this->_json['rows'] = end($this->_json['rows']);
        $this->_saveResultToMysql();
        header('view:' . 'http://' .$_SERVER['SERVER_NAME'].'/modules/debugax/www/index.php' );
    	return true;
    }

    protected function _saveResultToMysql()
    {

        $oDb = oxDb::getDb(true);
        $arr = $this->_getLogArray();
        $sSql = "insert into adodb_debugphp_logsql (created, params, sql1,tracer, type, ident) values( ?,?,?,?,?,?)";
        $test = $oDb->Execute($sSql,$arr);
        // print_r($arr);
        // print_r($test);
        // die('<br>die: ' . __FUNCTION__ .' / '. __FILE__ .' / '. __LINE__);
    }

    protected function _getLogArray()
    {
        return array(
            'a' => date('Y-m-d H:i:s'),
            'b' => serialize($this->_json['rows'][0]),
            'c' => serialize($this->_json['rows'][1]),
            'd' => $this->_json['rows'][2],
            'e' => $this->_json['rows'][3],
            'f' => $_SESSION['debugPHP']
        );
    }


}