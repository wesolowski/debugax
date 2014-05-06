<?php

class chromephp_admin_perform extends oxAdminDetails
{
    protected $_sThisTemplate = '../../../modules/debugax/Admin/chromephp/Templates/perform.tpl';

    protected $oTestPerformance = null;

    protected function _getTestPerformance()
    {
        if(is_null($this->oTestPerformance))
        {
            $this->oTestPerformance = oxNew('testPerformance');
        }
        return $this->oTestPerformance;
    }
    /**
     * [render description]
     * @author Rafal Wesolowski
     * @access public
     * @return [type]          [description]
     */
    public function render()
    {
        parent::render();
        $this->_aViewData["oxid"] = 'chromephp';

        if($this->_aViewData["bPerform"] != true && $this->_aViewData["bPerformTestResult"] != true)
        {
            $this->_aViewData["aUrls"] = $this->_getTestPerformance()->getUrls();
        }
        $this->_aViewData["aPerformTest"] = $this->_getTestPerformance()->getPerformTestResult();
        return $this->_sThisTemplate;
    }

    protected function _getIframeUrl($sUrl, $iKey)
    {
        $sUrl .= (strpos($sUrl, '?') !== false) ? '&' : '?' ;
        return $sUrl . 'test=' . $this->_getTestPerformance()->getUrlSufix($iKey);
    }


    /**
     * [startPerformTest description]
     * @author Rafal Wesolowski
     * @access public
     * @return void
     */
    public function startPerformTest()
    {
        try
        {
            $this->_getTestPerformance()->changePerformFile();
            $aParams = $this->getConfig()->getParameter( "aUrls");
            foreach ($aParams as $iKey => $sValue)
            {
                $aUrlsIframe[$iKey] = $this->_getIframeUrl($sValue, $iKey);
            }
            $this->_aViewData["aUrlsIframe"]    = $aUrlsIframe;
            $this->_aViewData["aUrls"]          = $aParams;
            $this->_aViewData["bPerform"]       = true;
            $this->_aViewData["comment"]        = oxConfig::getParameter( "comment");
        }
        catch (Exception $e)
        {
            $this->_addErrorToDisplay($e->getMessage());
        }
    }

    protected function _addErrorToDisplay( $sParam )
    {
        oxUtilsView::getInstance()->addErrorToDisplay( $sParam );
    }
    /**
     *
     *
     * @author Rafal Wesolowski
     * @access public
     * @return void
     */
    public function stopPerformTest()
    {
        $this->_getTestPerformance()->setComment(oxConfig::getParameter( "comment"));
        if($this->_getTestPerformance()->checkPerformance())
        {
            $this->_aViewData["bPerformTestResult"] =  true;
            $aResult  = $this->_getTestPerformance()->getLastPerformTestResult();
            unset($aResult['date']);
            $this->_aViewData["aUrls"] = array_change_key_case($aResult, CASE_UPPER);
        }

        $this->_aViewData["bBackupResult"] =   $this->_getTestPerformance()->getMysqlDriverBackup();
    }


    public function deleteOne()
    {
        $iDeleteKey =  $this->getConfig()->getParameter( 'deleteOne' );
        if(!empty($iDeleteKey))
        {
            $this->_getTestPerformance()->deleteOneTestResult($iDeleteKey);
        }
    }


    public function deleteMore()
    {
        $aDeleteMore = $this->getConfig()->getParameter( 'deleteMore' );
        if(!empty($aDeleteMore) && count($aDeleteMore) > 0)
        {
            $this->_getTestPerformance()->deleteMoreTestResult($aDeleteMore);
        }
    }

}
