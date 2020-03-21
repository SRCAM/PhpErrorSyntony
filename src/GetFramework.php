<?php


namespace Syntony;


use Syntony\Drive\Think;
use Syntony\Exception\DriveNotFindException;
use Syntony\Handler\Handler;
use Syntony\Handler\Other;

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

        //检查框架是否存在
        if (class_exists(\think\App::class)) {
            $this->frameworkName = 'Think';
            $this->framework = \think\App::class;
        }
        //如果没有可以预处理的框架
        if (!isset($this->drive[$this->frameworkName])) {
            return new Other();
        } else {
            $classSpace = $this->drive[$this->frameworkName];
        }
        //加载框架驱动
        $classSpace = new $classSpace();
        return $classSpace->load($this->framework);
    }
}
