<?php


namespace ErrorTransmitting;


use ErrorTransmitting\Dispatch\Http;
use ErrorTransmitting\Exception\NotFindConfigException;

class Dispatch
{
    //配置文件
    private $config;
    //数据结果
    private $data;

    public function __construct($data, $config)
    {
        $this->data = $data;
        $this->config = $config;
    }


    //发送到邮箱
    public function emall()
    {

    }

    //发送到指定地址
    public function http()
    {

        if (!isset($this->config['http'])) {
            throw new NotFindConfigException('http config not find ');
        }

        $http = $this->config['http'];
        if (!isset($http['url'])) {
            throw new NotFindConfigException('http.url config not find ');
        }


        if (!isset($http['method'])) {
            throw new NotFindConfigException('http.url config not find ');
        }

        $method = strtolower($http['method']);

        return Http::getInstance()->setUrl($http['url'])->$method($this->data);
    }
}