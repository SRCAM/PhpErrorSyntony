<?php


namespace ErrorTransmitting;

use ErrorTransmitting\Exception\DriveNotFindException;
use ErrorTransmitting\Exception\HandlerNotFindException;
use ErrorTransmitting\Exception\NotErrorException;
use ErrorTransmitting\Exception\NotFindConfigException;
use ErrorTransmitting\Handler\Other;

class Factory
{
    //错误类型
    private $error;
    //实例化
    private static $instance;

    private $data;

    private $framework;

    /**
     * @var array 配置文件
     */
    private $config = [

        'http' => [
            'url' => '',
            'method' => ''
        ],

        'emall' => [

        ]
    ];

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
     * @return Factory
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * 获取配置文件
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    public static function create($config = '')
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * 捕获数据
     * @param $error
     * @return Dispatch
     * @throws DriveNotFindException
     */
    public function handler($error)
    {
        //获取框架信息
        $this->framework = GetFramework::create()->get();

        //处理错误信息
        $this->framework->setError($error)->handler();
        //获取错误信息集
        $this->data = $this->framework->toArray();

        return new Dispatch($this->data, $this->config);
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
        $form_params = [
            'form_params' => $data,
        ];
        try {
            $analytics = $client->request('POST', $config['url'], $form_params);
        } catch (\GuzzleHttp\Exception\ClientException $exception) {

        } catch (\GuzzleHttp\Exception\RequestException $exception) {

        }
    }

    /**
     * 错误信息
     */
    public function getError()
    {
        return $this->error;
    }
}
