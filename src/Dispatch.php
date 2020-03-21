<?php


namespace Syntony;


use Syntony\Dispatch\Http;
use Syntony\Exception\NotFindConfigException;

/**
 * 错误信息发送方法
 * Class Dispatch
 * @package ErrorTransmitting
 */
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


    /**
     * 发送错误信息到邮箱
     */
    public function emall()
    {

    }

    //发送到指定地址
    public function http()
    {
        //判断 http 配置是否存在
        if (!isset($this->config['http'])) {
            throw new NotFindConfigException('http config not find ');
        }
        $http = $this->config['http'];
        //判断 url 是否存在
        if (!isset($http['url'])) {
            throw new NotFindConfigException('http.url config not find ');
        }
        //判断请求类型是否存在
        if (!isset($http['method'])) {
            throw new NotFindConfigException('http.url config not find ');
        }
        //全部小写
        $method = strtolower($http['method']);
        //发送请求
        return Http::getInstance()->setUrl($http['url'])->$method($this->data);
    }
}
