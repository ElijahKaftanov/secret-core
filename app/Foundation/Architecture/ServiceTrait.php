<?php declare(strict_types=1);

namespace Classic\Secret\Core\Foundation\Architecture;


trait ServiceTrait
{
    private static $_instance;

//    private $_serviceMemory = [];
//
//    protected function app(string $service)
//    {
//        return $this->_serviceMemory[$service] ?? $this->_serviceMemory[$service] = app($service);
//    }
//
//    public static function rise()
//    {
//        if (isset(self::$_instance)) {
//            return self::$_instance;
//        }
//
//        return self::$_instance = \app(__CLASS__);
//    }

    /**
     * @return $this
     */
    public static function up()
    {
        if (isset(self::$_instance)) {
            return self::$_instance;
        }

        return self::$_instance = new self();
    }
}