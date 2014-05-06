<?php

class chromephp_oxutilsview extends chromephp_oxutilsview_parent
{

    /**
     * Erwietert Smarty um Connector-Plugin Verzeichnisse
     *
     * @author Rafal Wesolowski <info@styleAx.de>
     * @param boolean $blReload Reloading?
     * @return smarty
     */
    public function getSmarty( $blReload = false )
    {
        parent::getSmarty($blReload);
        self::$_oSmarty->plugins_dir[] = $this->_debugaxGetPluginDirectories();
        return self::$_oSmarty;
    }

    /**
     * Gibt eine Liste aller Connector-Plugin-Verzeichnissen zurueck
     *
     * @author Rafal Wesolowski <info@styleAx.de>
     * @return string
     */
    protected function _debugaxGetPluginDirectories()
    {
    	return substr(__DIR__,0, -10) . 'smarty';
    }

}