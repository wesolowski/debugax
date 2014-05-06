<?php

class chromephp_admin_file extends oxAdminDetails
{
    protected $_sThisTemplate = '../../../modules/debugax/Admin/chromephp/Templates/file.tpl';

    protected $_oFileManger = null;

    protected $_oMysqlManger = null;


    protected function _getFileManger()
    {
        if(is_null($this->_oFileManger))
        {
            $this->_oFileManger = oxNew('fileManager');
        }
        return $this->_oFileManger;
    }


    protected function _getMysqlManager()
    {
        if(is_null($this->_oMysqlManger))
        {
            $this->_oMysqlManger = oxNew('mysqlManager');
        }
        return $this->_oMysqlManger;
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

        $this->_aViewData["aFileInfo"] = $this->_getFileManger()->getFileInfo();
        $this->_aViewData["sUrlDir"] = $this->_getFileManger()->getDirFileUrl();

        $this->_aViewData["edit"] = $this->_getMysqlManager()->getConfigFile();
        $this->_aViewData["iCountMysql"] = (int) $this->_getMysqlManager()->countDebugMysql();
        $this->_aViewData["oxid"] = 'chromephp';
        return $this->_sThisTemplate;
    }


    public function save()
    {
        $aParams = oxConfig::getParameter( "editval");
        $this->_getMysqlManager()->saveConfig($aParams);
        $this->deleteMysql();
    }

    public function deleteMysql()
    {
        $this->_getMysqlManager()->clearDebugMysql();
    }

}
