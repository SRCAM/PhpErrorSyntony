<?php


namespace ErrorTransmitting;

use ErrorTransmitting\Exception\NotErrorException;
use ErrorTransmitting\Exception\NotFindConfigException;

class factory
{

    private $error;

    private static $instance;

    /**
     * Client constructor.
     * @param array $config 基础配置方法
     */
    private function __construct($config = [])
    {
        $this->config = $config;
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

    public static function create($config)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function handler($error)
    {
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
        $data['param'] = $class->getParam();
        $data['response'] = $class->getResponse();
        $data['error'] = $class->toArray();
        $this->error = $data['error'];
        $this->http($data);
        return true;
    }

    /**
     * http 请求
     */
    private function http($data)
    {
        $config = $this->config;
        if (!$config) {
            throw new NotFindConfigException('未找到配置');
        }
        if (!isset($config['url'])) {
            throw new NotFindConfigException('未找到配置');
        }
        $client = new \GuzzleHttp\Client(['verify' => false]);
        //异步请求
        $client->requestAsync('POST', $config['url'], $data);

    }

    /**
     * 错误信息
     */
    public function getError()
    {
        return $this->error;
    }
}
