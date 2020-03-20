<?php


namespace ErrorTransmitting;


use ErrorTransmitting\Exception\DriveNotFindException;
use ErrorTransmitting\Handler\Handler;
use think\Loader;

class GetFramework
{

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
     *  判断框架的大体类型
     */
    private function searchFramework()
    {
        //查询是否是thinkphp 框架
        if (class_exists(\think\App::class)) {
            $this->frameworkName = 'think';
            $this->framework = \think\App::class;
        }
        //拼接命名空间
        $classSpace = __NAMESPACE__ . '\\Drive\\' . ucfirst($this->frameworkName);
        //如果没有找到框架驱动
        if (!class_exists($classSpace)) {
            throw new DriveNotFindException($classSpace . ': not find drive');
        }
        //加载框架驱动
        $classSpace = new $classSpace();
        $framework = $classSpace->loade($this->framework);

        return $framework;
    }
}