<?php

class moduleManager extends oxBase
{
	protected $aInstalledModules = null;
	/**
	 * Name der eigenen Klasse
	 *
	 * @author     Rafal  Wesolowski
	 * @var string
	 */
	protected $_sClassName = 'moduleManager';

	protected $_sTmpPath = null;

	protected $_sResultFileName = 'modules.txt';

	protected $_aOverloadClass = null;

	protected $_oReflectionClass = null;

	public function __construct()
    {
    	parent::__construct();
    	$this->_initModuleManager();
    }



    protected function _initModuleManager()
    {
    	$this->_sTmpPath = substr(__DIR__, 0, -4) . 'tmp' . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR;
    	$this->_createDir($this->_sTmpPath);
    }

    protected function _createDir($sPath)
    {
        if (!is_dir($sPath))
        {
            mkdir($sPath, 0777);
        }
    }

	public function getInstalledModules()
	{
		if (is_null($this->aInstalledModules))
		{
			$this->_setInstalledModules();
		}
		return $this->aInstalledModules;
	}

	protected function _setInstalledModules()
	{
		$oDb = $this->_getDb();
		$sSql = $this->_getSqlForGetInstalledModules();
		$aResult = $oDb->getOne($sSql);
		if ($aResult !== false )
		{
			$this->aInstalledModules = unserialize($aResult);
		}
	}

	protected function _getSqlForGetInstalledModules()
	{
		$sSql = "SELECT DECODE(OXVARVALUE, '" . $this->getConfig()->getConfigParam( 'sConfigKey' ) . "') as decodedVar
				 FROM oxconfig
				 WHERE OXSHOPID = '" . $this->getConfig()->getShopId() . "'
				 AND OXVARNAME = 'aModules'";
		return $sSql;
	}


	public function getOverloadClass()
	{
		if($this->_aOverloadClass == null)
		{
			$this->_setOverloadClass();
		}
		return $this->_aOverloadClass;
	}

	public function getFunctionFromOxidClass($sOxidClass, $bStrtolower = false)
	{
		$aOverloadClass = $this->getOverloadClass();
		$aResult = $aOverloadClass[$sOxidClass];
		return ($bStrtolower) ? array_map('strtolower', $aResult) : $aResult;
	}

	public function _setOverloadClass()
	{
		$aOverloadClass = array_keys($this->getInstalledModules());
		foreach ($aOverloadClass as $sClassName)
		{
			if(class_exists($sClassName))
			{
				$class = new ReflectionClass($sClassName);

				$methods = $class->getMethods();
				foreach ($methods as $value)
				{
					$aArray[$sClassName][] = $value->name;
				}
			}
		}

		$this->_aOverloadClass = $aArray;

		return $this;
	}


	public function getModuleContentClass()
	{
		$aOverloadClass = array_keys($this->getInstalledModules());
		foreach ($aOverloadClass as $sOxidClass)
		{
			$aResult[$sOxidClass] = ($aResultClass = $this->_isExceptionClass( $sOxidClass )) ? array_filter( $aResultClass ) : null ;
		}
		ksort($aResult);
		//return $this->saveResultFile(array('oxpaymentgateway' => $aResult['oxpaymentgateway'] ));
		return $this->saveResultFile(array_filter($aResult));
	}

	protected function _getAllModulesInfo( $sOxidClass )
	{
		$oOxidClass = oxNew( $sOxidClass );

		$sLastClassName = get_class($oOxidClass);
		return (strtolower($sLastClassName) != strtolower($sOxidClass)) ? $this->_getClassContent($sOxidClass,  $sLastClassName) : null;
	}

	protected function _isExceptionClass( $sOxidClass )
	{
		return ( strtolower($sOxidClass) != 'oxexception' && class_exists( $sOxidClass ) ) ? $this->_getAllModulesInfo( $sOxidClass )  : null;
	}

	protected function _getClassContent($sOxidClass, $sLastClassName)
	{
		$oReflectionClass = new ReflectionClass( $sLastClassName  );
		$aResult[] = $this->_getAllInfoFromClass($sOxidClass, $sLastClassName, $oReflectionClass);

		$this->_oReflectionClass = $oReflectionClass->getParentClass()->getParentClass();
		while (strtolower($this->_oReflectionClass->getShortName()) != strtolower($sOxidClass))
		{
			$aResult[] = $this->_getParentClass( $sOxidClass );
		}
		return $aResult;
	}

	protected function _getParentClass( $sOxidClass )
	{
		$oResult = $this->_getAllInfoFromClass($sOxidClass, $this->_oReflectionClass->getShortName(), $this->_oReflectionClass);
		$this->_oReflectionClass = $this->_oReflectionClass->getParentClass()->getParentClass();
		return $oResult;
	}

	protected function _getAllInfoFromClass($sOxidClass, $sLastClassName, $oReflectionClass)
	{
		$methods = $oReflectionClass->getMethods();
		$oModuleManagerList = null;
		$aFunction = array();
		foreach ($methods as $oModule)
		{
			$aFunction[] = $this->_getModuleFunction($oModule, $sLastClassName);
		}


		//$aShareFunction = $this->_getShareFunction( array_filter($aFunction), $sOxidClass );
		$aShareFunction = $this->_getAllShareFunction( array_filter($aFunction), $sOxidClass );

		//$array = array_map('strtolower', $aFunction);
		if(!empty($aShareFunction))
		{
			$oModuleManagerList = oxNew( 'moduleManagerList', $oReflectionClass );
			$oModuleManagerList->setFunctions( $aShareFunction );
		}

		return $oModuleManagerList;
	}


	protected function _getModuleFunction($oModule, $sModuleClassName)
	{
		return ($oModule->class == $sModuleClassName) ? $oModule->name : null;
	}

	protected function _getAllShareFunction(array $aFunction, $sOxidClass)
	{
		$aShareFunction           = $this->_getShareFunction( $aFunction, $sOxidClass );
		$aStrtolowerShareFunction = $this->_getShareFunction( array_map('strtolower', $aFunction), $sOxidClass, true );

		return ( count($aShareFunction) < count($aStrtolowerShareFunction)
				|| ( $aShareFunction === false && $aStrtolowerShareFunction !== false ) )
			?
			$aStrtolowerShareFunction
			:
			$aShareFunction ;
	}

	protected function _getShareFunction(array $aFunction, $sOxidClass, $bStrtolower = false)
	{
		$aClassResult = null;
		if(!empty($aFunction))
		{

			$aClassResult = array_intersect($aFunction, $this->getFunctionFromOxidClass($sOxidClass, $bStrtolower));
		}
		return (!is_null($aClassResult) && count($aClassResult) > 0) ? array_values($aClassResult) : false;
	}


	protected function _getModulesClassNames()
	{
		$aOverloadClass = $this->getInstalledModules();
		foreach ($aOverloadClass as $sOxidClassName => $sModule)
		{
			$aResult[$sOxidClassName] = $this->_isMoreModulesInString( $sModule );
		}
		return $aResult;
	}

	public function getResultFile()
	{
		$sFilePath = $this->_sTmpPath . $this->_sResultFileName;
		return (file_exists($sFilePath)) ? unserialize(file_get_contents($sFilePath)) : array() ;
	}

	public function saveResultFile(array $aParams)
    {
        return file_put_contents($this->_getResultFileName(), serialize($aParams));
    }

    protected function _getResultFileName()
    {
    	return $this->_sTmpPath . $this->_sResultFileName;
    }


	/**
	 * Liefert die Datenbankverbindung
	 *
	 * @author Rafal  Wesolowski
	 * @return oxDb
	 */
	protected function _getDb()
	{
		return oxDb::getDb(false);
	}
}
