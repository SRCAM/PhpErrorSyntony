<?php


namespace ErrorTransmitting;


use ErrorTransmitting\Drive\Think;
use ErrorTransmitting\Exception\DriveNotFindException;
use ErrorTransmitting\Handler\Handler;
use ErrorTransmitting\Handler\Other;

class GetFramework
{

    private $drive = [
        'Think' => Think::class
    ];
    //框架名称
    private $frameworkName;
    //框架核心组件
    private $framework;
    private static $instance;

    private function __construct()
    {

    }

    /**
     * 查询驱动是否存在
     * @return Handler
     * @throws DriveNotFindException
     */
    public function get()
    {
        return $this->searchFramework();
    }

    public static function create()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 判断框架的大体类型 /
     * @return Handler;
     */
    private function searchFramework()
    {
        return new Other();
    }
}