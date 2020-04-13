<?php

namespace Syntony\Dispatch;

use Syntony\Exception\NotFindConfigException;

class Http
{
    private $url;
    private $client;
    private static $instance;

    /**
     * Http constructor.
     * @param string $url
     */
    private function __construct($url = '')
    {
        //不对http进行校验
        $this->client = new \GuzzleHttp\Client(['verify' => false]);
        $this->url = $url;
    }

    /**
     * post处理请求
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($data)
    {
        $data = empty($data) ? [] : $data;
        $form_params = [
            'form_params' => $data,
        ];
        return $this->hander("POST", $form_params);
    }

    /**
     * get请求
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($data)
    {
        $data = empty($data) ? [] : http_build_query($data);
        $url = $this->url . '?' . $data;
        return $this->hander($url, "GET");
    }

    /**
     * 设置url
     * @param $url
     * @return Http
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $url
     * @return Http
     */
    public static function getInstance($url = '')
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($url);
        }
        return self::$instance;
    }

    /**
     * 结果
     * @param string $method
     * @param array $data
     * @return array|string
     */
    private function hander($method = 'GET', $data = [])
    {

        try {
            return $this->client->request($method, $this->url, $data)->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            return '';
        } catch (\GuzzleHttp\Exception\RequestException $exception) {
            return '';
        }
    }
    /**
     * 不存在方法捕获
     * @param $name
     * @param $arguments
     * @throws NotFindConfigException
     */
    public function __call($name, $arguments)
    {
        throw new NotFindConfigException($name . ' not find');
    }
}
