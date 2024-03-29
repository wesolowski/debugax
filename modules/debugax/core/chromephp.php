<?php

require_once substr(__DIR__, 0, -4) . 'function.php';

require_once __DIR__ . DS . 'include' . DS . 'chromephpmysql.php';
require_once __DIR__ . DS . 'include' . DS . 'chromephpblocked.php';
require_once __DIR__ . DS . 'include' . DS . 'chromephpmysqlreading.php';
require_once __DIR__ . DS . 'include' . DS . 'chromephpfile.php';
require_once __DIR__ . DS . 'include' . DS . 'chromephpheader.php';
require_once __DIR__ . DS . 'authorization.php';



class chromephp
{
    protected $_sClassName = 'chromephp';

    /**
     * @var string
     */
    const VERSION = '3.0';

    /**
     * @var string
     */
    const HEADER_NAME = 'X-ChromePhp-Data';

    /**
     * @var string
     */
    const BACKTRACE_LEVEL = 'backtrace_level';

    /**
     * @var string
     */
    const LOG = 'log';

    /**
     * @var string
     */
    const WARN = 'warn';

    /**
     * @var string
     */
    const ERROR = 'error';

    /**
     * @var string
     */
    const GROUP = 'group';

    /**
     * @var string
     */
    const INFO = 'info';

    /**
     * @var string
     */
    const GROUP_END = 'groupEnd';

    /**
     * @var string
     */
    const GROUP_COLLAPSED = 'groupCollapsed';

    /**
     * @var string
     */
    protected $_php_version;

    /**
     * @var int
     */
    protected $_timestamp;

    /**
     * @var array
     */
    protected $_json = array(
        'version' => self::VERSION,
        'columns' => array('label', 'log', 'backtrace', 'type'),
        'rows' => array()
    );

    /**
     * @var array
     */
    protected $_backtraces = array();

    /**
     * @var bool
     */
    protected $_error_triggered = false;

    /**
     * @var array
     */
    protected $_settings = array(
        self::BACKTRACE_LEVEL => 1
    );

    /**
     * @var ChromePhp
     */
    protected static $instance;

    /**
     * Prevent recursion when working with objects referring to each other
     *
     * @var array
     */
    protected $_processed = array();


    protected static $sChromeClassName = null;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->_php_version = phpversion();
        $this->_timestamp = $this->_php_version >= 5.1 ? $_SERVER['REQUEST_TIME'] : time();
        $this->_json['request_uri'] = $_SERVER['REQUEST_URI'];
    }


    protected static function _setClassName($bReading = false)
    {
        $oAutorization = new authorization;
        self::$sChromeClassName =  $oAutorization->getClassName($bReading);
    }

    public static function clearSingelton()
    {
        self::$instance = self::$sChromeClassName = null;
    }

    /**
     * gets instance of this class
     *
     * @return ChromePhp
     */

    public static function getInstance($bReading = false)
    {
        if(is_null(self::$sChromeClassName))
        {
            self::_setClassName($bReading);
        }

        ( !function_exists( 'oxNew' ) ) ? self::_getPhpInstance() : self::_getOxidInstance();

        return self::$instance;
    }

    protected static function _getOxidInstance()
    {

        if ( is_null(self::$instance) || !self::$instance instanceof self::$sChromeClassName )
        {
            self::$instance = oxNew( self::$sChromeClassName );
        }
    }

    protected static function _getPhpInstance()
    {
        if ( is_null(self::$instance) || !self::$instance instanceof self::$sChromeClassName )
        {
            self::$instance = new self::$sChromeClassName;
        }
    }


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
        $args = func_get_args();
        $severity = count($args) == 3 ? array_pop($args) : '';
        // save precious bytes
        if ($severity == self::LOG) {
            $severity = '';
        }

        return self::_log($args + array('type' => $severity));
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
        return self::_log(func_get_args() + array('type' => self::WARN));
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
        return self::_log(func_get_args() + array('type' => self::ERROR));
    }

    /**
     * sends a group log
     *
     * @param string value
     */
    public static function group()
    {
        return self::_log(func_get_args() + array('type' => self::GROUP));
    }

    /**
     * sends an info log
     *
     * @param string value
     */
    public static function info()
    {
        return self::_log(func_get_args() + array('type' => self::INFO));
    }

    /**
     * sends a collapsed group log
     *
     * @param string value
     */
    public static function groupCollapsed()
    {
        return self::_log(func_get_args() + array('type' => self::GROUP_COLLAPSED));
    }

    /**
     * ends a group log
     *
     * @param string value
     */
    public static function groupEnd()
    {
        return self::_log(func_get_args() + array('type' => self::GROUP_END));
    }

    /**
     * internal logging call
     *
     * @param string $type
     * @return void
     */
    protected static function _log(array $args)
    {
        $type = $args['type'];
        unset($args['type']);

        // nothing passed in, don't do anything
        if (count($args) == 0 && $type != self::GROUP_END) {
            return;
        }

        // default to single
        $label = null;
        $value = isset($args[0]) ? $args[0] : '';

        $logger = self::getInstance();

        // if there are two values passed in then the first one is the label
        if (count($args) == 2) {
            $label = $args[0];
            $value = $args[1];
        }

        $logger->_processed = array();
        $value = $logger->_convert($value);

        $backtrace = debug_backtrace(false);
        $level = $logger->getSetting(self::BACKTRACE_LEVEL);

        $backtrace_message = 'unknown';
        if (isset($backtrace[$level]['file']) && isset($backtrace[$level]['line'])) {
            $backtrace_message = $backtrace[$level]['file'] . ' : ' . $backtrace[$level]['line'];
        }

        $logger->_addRow($label, $value, $backtrace_message, $type);
    }

    /**
     * converts an object to a better format for logging
     *
     * @param Object
     * @return array
     */
    protected function _convert($object)
    {
        // if this isn't an object then just return it
        if (!is_object($object)) {
            return $object;
        }

        //Mark this object as processed so we don't convert it twice and it
        //Also avoid recursion when objects refer to each other
        $this->_processed[] = $object;

        $object_as_array = array();

        // first add the class name
        $object_as_array['___class_name'] = get_class($object);

        // loop through object vars
        $object_vars = get_object_vars($object);
        foreach ($object_vars as $key => $value) {

            // same instance as parent object
            if ($value === $object || in_array($value, $this->_processed, true)) {
                $value = 'recursion - parent object [' . get_class($value) . ']';
            }
            $object_as_array[$key] = $this->_convert($value);
        }

        $reflection = new ReflectionClass($object);

        // loop through the properties and add those
        foreach ($reflection->getProperties() as $property) {

            // if one of these properties was already added above then ignore it
            if (array_key_exists($property->getName(), $object_vars)) {
                continue;
            }
            $type = $this->_getPropertyKey($property);

            if ($this->_php_version >= 5.3) {
                $property->setAccessible(true);
            }

            try {
                $value = $property->getValue($object);
            } catch (ReflectionException $e) {
                $value = 'only PHP 5.3 can access private/protected properties';
            }

            // same instance as parent object
            if ($value === $object || in_array($value, $this->_processed, true)) {
                $value = 'recursion - parent object [' . get_class($value) . ']';
            }

            $object_as_array[$type] = $this->_convert($value);
        }
        return $object_as_array;
    }

    /**
     * takes a reflection property and returns a nicely formatted key of the property name
     *
     * @param ReflectionProperty
     * @return string
     */
    protected function _getPropertyKey(ReflectionProperty $property)
    {
        $sResult = null;
        $static = $property->isStatic() ? ' static' : '';
        if ($property->isPublic()) {
            $sResult = 'public' . $static . ' ' . $property->getName();
        }
        else if ($property->isProtected())
        {
            $sResult = 'protected' . $static . ' ' . $property->getName();
        }
        else if ($property->isPrivate()) {
            $sResult = 'private' . $static . ' ' . $property->getName();
        }
        return $sResult;
    }

    /**
     * adds a value to the data array
     *
     * @var mixed
     * @return void
     */
    protected function _addRow($label, $log, $backtrace, $type)
    {
        // if this is logged on the same line for example in a loop, set it to null to save space
        if (in_array($backtrace, $this->_backtraces)) {
            $backtrace = null;
        }

        if ($backtrace !== null) {
            $this->_backtraces[] = $backtrace;
        }

        $row = array($label, $log, $backtrace, $type);

        $this->_json['rows'][] = $row;
        $this->_writeHeader($this->_json);
    }

    protected function _writeHeader($data)
    {
        header(self::HEADER_NAME . ': ' . $this->_encode($data));
    }

    /**
     * encodes the data to be sent along with the request
     *
     * @param array $data
     * @return string
     */
    protected function _encode($data)
    {
        return base64_encode(utf8_encode(json_encode($data)));
    }

    /**
     * adds a setting
     *
     * @param string key
     * @param mixed value
     * @return void
     */
    public function addSetting($key, $value)
    {
        $this->_settings[$key] = $value;
    }

    /**
     * add ability to set multiple settings in one call
     *
     * @param array $settings
     * @return void
     */
    public function addSettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            $this->addSetting($key, $value);
        }
    }

    /**
     * gets a setting
     *
     * @param string key
     * @return mixed
     */
    public function getSetting($key)
    {
        if (!isset($this->_settings[$key])) {
            return null;
        }
        return $this->_settings[$key];
    }

}


