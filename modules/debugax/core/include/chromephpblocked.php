<?php


class chromephpBlocked extends chromephp{


     /**
     * logs a variable to the console
     *
     * @param string label
     * @param mixed value
     * @param string severity ChromePhp::LOG || ChromePhp::WARN || ChromePhp::ERROR
     * @return void
     */
    public static function log()
    {

        return true;
    }

    /**
     * logs a warning to the console
     *
     * @param string label
     * @param mixed value
     * @return void
     */
    public static function warn()
    {
        return true;
    }

    /**
     * logs an error to the console
     *
     * @param string label
     * @param mixed value
     * @return void
     */
    public static function error()
    {
        return true;
    }

    /**
     * sends a group log
     *
     * @param string value
     */
    public static function group()
    {
        return true;
    }

    /**
     * sends an info log
     *
     * @param string value
     */
    public static function info()
    {
        return true;
    }

    /**
     * sends a collapsed group log
     *
     * @param string value
     */
    public static function groupCollapsed()
    {
        return true;
    }

    /**
     * ends a group log
     *
     * @param string value
     */
    public static function groupEnd()
    {
        return true;
    }


}
