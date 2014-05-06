<?php

class Helper_Modules extends oxUBase
{
	protected $_sThisTemplate = "../../../modules/debugax/view/tpl/helper_modules.tpl";


	protected $_oModuleManager = null;

	/**
	 * Ueberladen die Render
	 *
	 * @author Rafal  Wesolowski
	 * @return string
	 */
	public function render()
	{
		parent::render();
		$this->_aViewData["sOxid"] = $sOxid = oxConfig::getParameter( "oxid" );
		$this->_getModulesAnalize();

		$this->_aViewData["sView"] = __CLASS__;

		return $this->_sThisTemplate;

	}

	protected function _getModulesAnalize()
	{
		$bStart = oxConfig::getParameter( "start" );
		if( $bStart == true )
		{
			$this->_getModuleManager()->getModuleContentClass();
		}

		$aModules = $this->_getModuleManager()->getResultFile();
		$iCountResult = (int) count( $aModules );
		$this->addTplParam( 'iCountResult', $iCountResult );

		$oModuleAnalize = oxNew( 'moduleManagerAnalize' );
		$bResult = $oModuleAnalize->setAnalize();
		$this->addTplParam( 'bResult', $bResult  );

		if($bResult == true)
		{
			$this->_getProgress( $aModules );
		}
		else
		{
			$this->addTplParam( 'iProgress', $iCountResult  );
		}
	}

	protected function _getProgress( array $aModules )
	{
		$iProgress = 1;
		foreach ( $aModules as $aModuleList )
		{
			$iProgress += ( is_null( current($aModuleList)->isEncode() ) ) ? 0 :  1;
		}
		$this->addTplParam( 'iProgress', (int) $iProgress  );
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
