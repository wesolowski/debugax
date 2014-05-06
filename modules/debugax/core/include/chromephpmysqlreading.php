<?php

class chromephpMysqlReading extends chromephp
{

    protected function _writeHeader($data)
    {
    	return true;
    }

    public function getJsonResult()
    {
        $oDebugaxConfig = new Debugax_Config();
        echo json_encode($oDebugaxConfig->clean_trace($this->_json));
    }


}