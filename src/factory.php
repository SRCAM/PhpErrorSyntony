<?php


namespace ErrorTransmitting;

use ErrorTransmitting\Exception\NotErrorException;

class factory
{

    /**
     * Client constructor.
     * @param array $config 基础配置方法
     */
    private function __construct($config = [])
    {
        $this->config = $config;
        $client = new \GuzzleHttp\Client();
    }

    /**
     * 捕设置配置文件
     * @param $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * 获取配置文件
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    public static function create()
    {

    }

    public function handler($error)
    {
//获取框架信息,tp框架
        $frame = '';
        if (class_exists(think\App::class)) {
            $frame = 'think';
        } else {
            throw new NotErrorException('暂不支持该框架');
        }
        /**
         * @package \ErrorTransmitting\Handler\handler
         */
        $classSpace = __NAMESPACE__ . '\\Handler\\' . ucfirst($frame);
        if (!class_exists($classSpace)) {
            throw new NotErrorException('暂不支持该框架: ');
        }
        $class = new $classSpace($error);
        $handler = $class->handler();
        //如果错误无需处理

        
        if (!$handler) {
            return false;
        }

    }

    /**
     * 错误信息
     */
    public function catchError($error)
    {


    }
}
