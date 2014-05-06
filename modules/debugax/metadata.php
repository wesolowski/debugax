<?php

/**
 * Module information
 */
$aModule = array(
    'id'           => 'debugAx',
    'title'        => 'debugAx',
    'description'  => 'Debug SQL-Query by ChromePHP  Helper',
    'thumbnail'    => 'picture.png',
    'version'      => '1.0',
    'author'       => 'Rafal Wesolowski',
    'email'        => 'info@styleAx.de',
    'extend'       => array(
        'oxshopcontrol' => 'debugax/extensions/chromephp_oxshopcontrol',
        'oxUtilsView' => 'debugax/extensions/chromephp_oxutilsview',
    )
);