<?php

class testPerformance
{
    /**
     * Name der eigenen Klasse
     * @access protected
     * @var string
     */
    protected $_sClassName = 'testPerformance';
    /**
     *
     * @author Rafal Wesolowski
     * @access protected
     * @var string
     */
    protected $_bBackupStatus = false;
    /**
     *
     * @author Rafal Wesolowski
     * @access protected
     * @var string
     */
    protected $_sPerformPath = null;
    /**
     *
     * @author Rafal Wesolowski
     * @access protected
     * @var string
     */
    protected $_sPerformResultFile = null;


    /**
     *
     * @author Rafal Wesolowski
     * @access protected
     * @var string
     */
    protected $_sPerformFolder = 'perform';

    protected $sComment = null;


    protected $_oFileManager = null;
    /**
     * [__construct description]
     * @author Rafal           Wesolowski
     * @access public
     */


    protected $aUrlSufix = array(
                1 => 'start',
                2 => 'list',
                3 => 'details'
            );

    public function __construct()
    {
        $this->init();
    }


    public function getUrlSufix($iKey)
    {
        return $this->aUrlSufix[$iKey];
    }

    protected function _getFileManager()
    {
        if(is_null($this->_oFileManager))
        {
           $this->_oFileManager = oxNew('fileManager');
        }
        return $this->_oFileManager;
    }
    /**
     * [init description]
     * @author Rafal           Wesolowski
     * @access public
     * @return [type]          [description]
     */
    public function init()
    {
        $this->_sPerformPath = $this->_getFileManager()->getTmpPath() . $this->_sPerformFolder .DIRECTORY_SEPARATOR;
        $this->_sPerformResultFile = $this->_getFileManager()->getTmpPath() . 'resultPerformTest.json';
        $this->_bBackupStatus = $this->_getFileManager()->checkBackup();

        $this->_getFileManager()->createDir($this->_sPerformPath);

    }

    /**
     * [FunctionName description]
     * @author Rafal           Wesolowski
     * @access public
     * @param  array
     */
    public function getPerformTestResult()
    {
        return (file_exists($this->_sPerformResultFile)) ? json_decode(file_get_contents($this->_sPerformResultFile), true) : array();
    }



    public function getLastPerformTestResult()
    {
        $aResult = $this->getPerformTestResult();
        return (!empty($aResult)) ? end($aResult) : array();
    }
    /**
     * [changePerformFile description]
     * @author Rafal           Wesolowski
     * @access public
     * @return [type]          [description]
     */
    public function changePerformFile()
    {
        if(!$this->_getFileManager()->changePerformFile())
        {
            throw new oxException( 'CHROME_EXCEPTION_PERFORMTEST_START');
        }
        sleep(3);
    }


    /**
     * [checkPerformance description]
     * @author Rafal           Wesolowski
     * @access public
     * @return [type]          [description]
     */
    public function checkPerformance()
    {
        $bResult = false;
        if($this->_bBackupStatus == true)
        {
            $aResultCount = $this->_countTest();
            $bResult = $this->_savePerformanceTest($aResultCount);
        }
        return $bResult;

    }


    /**
     * [getSComment() description here]
     * @access public
     * @author Rafal Wesolowski
     * @return [type] [description]
     */
    public function getComment()
    {
        return $this->sComment;
    }

    /**
     * [setSComment() description here]
     *
     * @param  [type] $sComment [description]
     * @access public
     * @author Rafal Wesolowski
     * @return [class type]    $this
     */
    public function setComment($newComment = false)
    {
        $newComment .= (!empty($newComment)) ? ' | ' : '' ;
        $this->sComment = $newComment . date("Y-m-d H:i:s");
        return $this;
    }

    /**
     * [_countTest description]
     * @author Rafal           Wesolowski
     * @access protected
     * @return [type]          [description]
     */
    protected function _countTest()
    {
        $aTest = array();
        $aTest['comment'] = $this->getComment();
        $dh  = opendir($this->_sPerformPath);

        while (false !== ($filename = readdir($dh)))
        {
            if($filename != '.' && $filename != '..')
            {
                $sUrl = $this->_sPerformPath . DIRECTORY_SEPARATOR . $filename;
                $aTest[substr($filename, 0, -4)] = count(file($sUrl));
                unlink($sUrl);
            }
        }
        return $aTest;
    }


    /**
     * [_savePerformanceTest description]
     * @author Rafal           Wesolowski
     * @access protected
     * @param  array           $aParams   [description]
     * @return [type]                     [description]
     */
    protected function _savePerformanceTest(array $aParams)
    {
        $aResult = $this->getPerformTestResult();
        $aResult[] = $aParams;
        return $this->_saveTestFile($aResult);
    }


    protected function _saveTestFile(array $aParams)
    {
        return (!empty($aParams)) ? file_put_contents($this->_sPerformResultFile, json_encode($aParams)) : false;
    }


    public function deleteOneTestResult($iKey = null)
    {
        $aResult = $this->getPerformTestResult();
        unset($aResult[$iKey]);
        return $this->_saveTestFile(array_values($aResult));
    }


    public function deleteMoreTestResult(array $aKey)
    {
        $aResult = $this->getPerformTestResult();
        foreach ($aKey as $iKey)
        {
            unset($aResult[$iKey]);
        }
        return $this->_saveTestFile(array_values($aResult));
    }

    /**
     * [getBackup description]
     * @author Rafal           Wesolowski
     * @access public
     * @return [type]          [description]
     */
    public function getMysqlDriverBackup()
    {
        return $this->_getFileManager()->backup();
    }



    /**
     * [getUrls description]
     * @author Rafal           Wesolowski
     * @access public
     * @return [type]          [description]
     */
    public function getUrls()
    {
        return array(  1 => oxConfig::getInstance()->getShopUrl(),
                       2 => $this->_getSeoUrl('oxcategory') ,
                       3 => $this->_getSeoUrl('oxarticle')
                    );
    }



    /**
     * [_getSeoUrl description]
     * @author Rafal           Wesolowski
     * @access protected
     * @param  [type]          $sCoreName [description]
     * @return [type]                     [description]
     */
    protected function _getSeoUrl( $sCoreName)
    {
        $oList = oxNew( 'oxlist' , $sCoreName);
        $oList->setSqlLimit(5, 5);
        $oList->getList();
        return ($oList->current() instanceOf $sCoreName) ? $oList->current()->getLink() : null;
    }

}
