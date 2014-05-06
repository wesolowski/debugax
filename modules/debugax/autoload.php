<?php

function debugaxAutoload($sClass) {

    $sClass = basename($sClass);
    $sBasePath = getShopBasePath();
    $sClass = strtolower($sClass);

    $aClassDirs = array(
        $sBasePath . 'modules/debugax/',
        $sBasePath . 'modules/debugax/Admin/',
        $sBasePath . 'modules/debugax/Admin/chromephp/',
        $sBasePath . 'modules/debugax/Admin/helper/',
        $sBasePath . 'modules/debugax/core/',
        $sBasePath . 'modules/debugax/view/',
    );

    foreach ($aClassDirs as $sDir) {
        $sFilename = $sDir . strtolower($sClass) . '.php';
        if (file_exists($sFilename)) {
            include $sFilename;
            return;
        }
    }
}


spl_autoload_register("debugaxAutoload");

include 'function.php';
