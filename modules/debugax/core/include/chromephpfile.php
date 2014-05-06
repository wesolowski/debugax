<?php
/**
 * Copyright 2012 Craig Campbell
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Server Side Chrome PHP debugger class
 *
 * @package ChromePhp
 * @author Craig Campbell <iamcraigcampbell@gmail.com>
 */
class chromephpFile extends chromephp{


    protected function _writeHeader($data)
    {
        $sFileName = $this->_getFileName();
        $this->_writeFile($data, $sFileName);
        $sFileUrl  = oxConfig::getInstance()->getShopUrl() .  'modules/debugax/tmp/file/'. $sFileName. '.json';
        header('filedebug :' .  $sFileUrl);
        return true;
    }


    protected function _getFileName()
    {
        $sFileName = '';
        if(oxSession::hasVar( 'debugPHP' ) && oxSession::getVar('debugPHP') !== true)
        {
            $sFileName = oxSession::getVar('debugPHP');
        }
        return $sFileName .= ( isAdmin()) ? '_admin'  : '_shop' ;
    }


    protected function _writeFile($data, $sFileName)
    {
        $this->_getFileFolderPath() . $sFileName . '.json';
        $f = fopen( $this->_getFileFolderPath() . $sFileName . '.json', 'w' );
        fputs( $f, json_encode($data));
        fclose( $f );
    }


    protected function _getFileFolderPath()
    {
    	return current(explode('core',__DIR__)) . 'tmp' . DS . 'file' . DS;
    }

}
