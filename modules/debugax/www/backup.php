<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');


class oxConfig
{
    /*
     * oxConfig instance
     *
     * @var oxconfig
     */
    private static $_instance = null;


    /**
     * Returns config parameter value if such parameter exists
     *
     * @param string $sName config parameter name
     *
     * @return mixed
     */
    public function getConfigParam( $sName = null)
    {
        $sResult ='';
        if($sName == 'sShopDir')
        {
            $sResult = substr(__DIR__, 0, -19);
        }
        return $sResult;
    }


    /**
     * Returns singleton oxConfig object instance or create new if needed
     *
     * @return oxConfig
      */
    public static function getInstance()
    {
        if ( !self::$_instance instanceof oxConfig ) {
                //exceptions from here go directly to global exception handler
                //if no init is possible whole application has to die!
                self::$_instance = new oxConfig();
        }
        return self::$_instance;
    }
}

    require_once substr(__DIR__, 0, -3) . 'core'. DIRECTORY_SEPARATOR .  'filemanager.php';

    $oFileManager = new fileManager;
    $sFileConfigPath = substr(__DIR__, 0, -3) . 'tmp' . DIRECTORY_SEPARATOR . 'config.json';
    $aConfig = json_decode(file_get_contents( $sFileConfigPath ), true);
    $aConfig['debugActive'] = 0;
    file_put_contents($sFileConfigPath, json_encode($aConfig));

    var_export($oFileManager->getBackup());
