<?php

class moduleManagerAnalize extends oxBase
{

	/**
	 * Name der eigenen Klasse
	 *
	 * @author     Rafal  Wesolowski
	 * @var string
	 */
	protected $_sClassName = 'moduleManagerAnalize';

	protected $_oModuleManager = null;

    protected $_bCurrentClass = false;

	protected $_aModules = array();

	public function __construct()
    {
    	parent::__construct();
    	$this->_initModuleManagerAnalize();
    }

    protected function _initModuleManagerAnalize()
    {
    	$this->_aModules = $this->_getModuleManager()->getResultFile();
    }

    public function setAnalize()
    {
    	foreach ( $this->_aModules as $sOxidClassName => $aModules )
    	{
    		$this->_getCurrentModule( current($aModules) , $sOxidClassName );
    	}
        return $this->_bCurrentClass;
    }

    protected function _getCurrentModule( moduleManagerList $oModules, $sOxidClassName )
    {
        if( $this->_bCurrentClass == false && is_null( $oModules->isEncode() ) )
        {
            $this->_getClassPath( $sOxidClassName );
        }
    }

    protected function _getClassPath( $sOxidClassName )
    {
        $this->_bCurrentClass = true;
    	foreach ($this->_aModules[$sOxidClassName] as $iKey => $oModuleManagerList)
    	{
    		$this->_setEncode( $oModuleManagerList->getModulePath(), $oModuleManagerList->getClassName(), $iKey, $sOxidClassName );
    	}
    	$this->_getModuleManager()->saveResultFile( $this->_aModules );
    }

    protected function _setEncode( $sClassPath, $sClassName, $iKey, $sOxidClassName )
    {
    	$bIsEncode = $this->_isEncode( $sClassPath, $sClassName, $sOxidClassName, $iKey );

    	$this->_aModules[$sOxidClassName][$iKey]->setEncode( $bIsEncode );
    }

    protected function _isEncode( $sClassPath, $sClassName, $sOxidClassName, $iKey )
    {
    	$sClassCode = file_get_contents($sClassPath);
    	$bResult = ( strpos($sClassCode, $sClassName) ) ? false : true;

        return ( $bResult ) ?  $this->_getEncodeContent( $sClassName, $sOxidClassName, $sClassPath, $iKey ) : false;
    }


    protected function _getEncodeContent( $sClassName, $sOxidClassName, $sClassPath, $iKey )
    {
        $sModuleTextInfo = $this->_getModuleInfo(  $sOxidClassName, $sClassName, $sClassPath );
        $this->_aModules[$sOxidClassName][$iKey]->setEncodeInfo( $sModuleTextInfo );
        return true;
    }


    protected function _getModuleInfo( $sOxidClass, $sSearchClassName, $sClassPath )
    {
        $oReflectionClass = $this->_getSearchReflectionClass( $sOxidClass, $sSearchClassName );
        $sReflectionClassInfo = $oReflectionClass->__toString();
        return $this->_getEndcodeClassInfo( $sReflectionClassInfo, $sClassPath );
    }



    protected function _getSearchReflectionClass( $sOxidClass, $sSearchClassName )
    {
        $oOxidClass = oxNew( $sOxidClass );
        $sLastClassName = get_class($oOxidClass);
        $oReflectionClass = new ReflectionClass( $sLastClassName  );

        return ( $sLastClassName != $sSearchClassName ) ?
                $this->_getParentReflectionClass( $oReflectionClass, $sSearchClassName )
                :
                $oReflectionClass;

    }

    protected function _getParentReflectionClass( $oReflectionClass, $sSearchClassName )
    {
        while ( $oReflectionClass->getShortName() != $sSearchClassName )
        {
            $oReflectionClass = $oReflectionClass->getParentClass()->getParentClass();
        }
        return $oReflectionClass;
    }

    protected function _getEndcodeClassInfo( $sReflectionClassInfo, $sClassPath )
    {
        $iLastMasterClassPath = strripos($sReflectionClassInfo, $sClassPath );
        $sReflectionClassInfoText1 = substr($sReflectionClassInfo, 0, $iLastMasterClassPath );

        $sReflectionClassInfoText2 = substr($sReflectionClassInfo, $iLastMasterClassPath );
        $iFirstBrace = stripos($sReflectionClassInfoText2, '}' );
        $sReflectionClassInfoText2 = substr($sReflectionClassInfoText2, 0, $iFirstBrace );

        return $sReflectionClassInfoText1 . $sReflectionClassInfoText2;
    }

    public function _getModuleManager()
    {
        if($this->_oModuleManager == null)
        {
            $this->_setModuleManager();
        }
        return $this->_oModuleManager;
    }

    public function _setModuleManager()
    {
        $this->_oModuleManager = oxNew('moduleManager');
    }
}
