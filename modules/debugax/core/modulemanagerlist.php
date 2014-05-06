<?php

class moduleManagerList
{

	/**
	 * Name der eigenen Klasse
	 *
	 * @author     Rafal  Wesolowski
	 * @var string
	 */
	protected $_sClassName = 'moduleManagerList';

	protected $_sModuleClassName = null;

	protected $_sPathModule = null;

    protected $_aFunctions = null;

    protected $_iEncode = null;

	protected $_aDecodeInfo = null;

    protected $_sEncodeText = null;

	public function __construct( ReflectionClass $oReflectionClass )
    {
    	$this->_init( $oReflectionClass );
    }

    protected function _init( ReflectionClass $oReflectionClass )
    {
    	$this->_sModuleClassName = $oReflectionClass->getShortName();
    	$this->_sPathModule = $oReflectionClass->getFileName();
    }

    public function setFunctions( array $aFunctions )
    {
    	$this->_aFunctions = $aFunctions;
    }

    public function getFunctions()
    {
        return $this->_aFunctions;
    }

    public function getClassName()
    {
        return $this->_sModuleClassName;
    }

    public function getModulePathForFronend()
    {
        return strstr($this->_sPathModule, 'modules/');
    }

    public function getModulePath()
    {
        return $this->_sPathModule;
    }

    public function isEncode()
    {
        return $this->_iEncode;
    }

    public function setEncode( $bEncode = false )
    {
        $this->_iEncode = $bEncode;
    }

    public function getEncodeInfo()
    {
        return $this->_sEncodeText;
    }

    public function setEncodeInfo( $sEncodeText )
    {
        $this->_sEncodeText = $sEncodeText;
    }

    public function getDecodeInfo()
    {
        return $this->_aDecodeInfo;
    }

    public function setDecodeInfo(array $aDecodeInfo)
    {
        $this->_aDecodeInfo = $aDecodeInfo;
    }
}
