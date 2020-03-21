<?php


/**
 * Class handler
 * @author  saber
 * @date  2020/3/17 22:31
 * @version 1.0
 */


namespace Syntony\Handler;


use syntony\Exception\HandlerError;
use Syntony\Exception\NotErrorException;
use Syntony\Exception\NotFindConfigException;


/**
 * 处理方法的基类
 * Class Handler
 * @package ErrorTransmitting\Handler
 */
abstract class Handler
{

    //配置文件
    protected $config;
    /**
     * @var  \Exception 错误类型
     */
    protected $error;
    /**
     * @var array 其他异常错误保存
     */
    protected $pdoError;


    /**
     * 获取返回数据
     */
    abstract protected function getParam();

    /**
     * 框架内部自我处理
     * @return mixed
     */
    abstract protected function selfHandler();

    /**
     * 获取url 地址
     * @return mixed
     */
    abstract protected function getUrl();

    /**
     * 获取cookie
     * @return mixed
     */
    abstract protected function getCookie();

    /**
     * 获取请求头
     * @return mixed
     */
    abstract protected function getHeader();

    /**
     * 获取
     * @return mixed
     */
    abstract protected function getMethod();

    /**
     * 设置错误
     * @param $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * 判断是否是异常类
     * @param $error
     * @throws NotErrorException
     */
    protected function isError()
    {
        if (!$this->error) {
            throw new NotErrorException('this class not !Exception');
        }

        if (!$this->error instanceof \Exception) {
            throw new NotErrorException('this class not !Exception');
        }
    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * 返回错误信息
     * @return array array
     */
    protected function getPdoError()
    {
        return $this->pdoError;
    }

    /**
     * 获取文件名称
     * @return string
     */
    protected function getFile()
    {
        return $this->error->getFile();
    }

    /**
     * 错误code
     * @return int|mixed
     */
    protected function getCode()
    {
        return $this->error->getCode() ? $this->error->getCode() : 500;
    }

    /**
     * @return int
     */
    protected function getLine()
    {
        return $this->error->getLine();
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->error->getMessage();
    }

    public function handler()
    {
        //检查改类是否是错误类
        $this->isError();
        //检查配置环境是否一致
        $this->isConfig();
        $self = $this->selfHandler();
        if (!$self) {
            return false;
        }
        return true;
    }

    /**
     * 获取配置文件信息
     * @throws NotFindConfigException
     */
    protected function isConfig()
    {
        //检查config 是否存在
        if (!$this->config) {
            throw new NotFindConfigException('config 不存在');
        }
        if (!isset($this->config['showType'])) {
            throw new NotFindConfigException('config.showType not find ');
        }
    }

    /**
     *
     */
    public function toArray()
    {
        $data['param'] = $this->getParam();
        $data['response'] = $this->getResponse();
        $data['sql_error'] = $this->getPdoError();
        $data['file'] = $this->getFile();
        $data['code'] = $this->getCode();
        $data['line'] = $this->getLine();
        $data['message'] = $this->getMessage();
        $data['url'] = $this->getUrl();
        $data['cookie'] = $this->getCookie();
        $data['header'] = $this->getHeader();
        $data['method'] = $this->getMethod();
        return $data;
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    protected function getResponse()
    {
        $show = $this->config['showType'];
        $handler = new HandlerError();
        return $handler->$show($this->error);
    }

    /**
     * 获取接送数据
     * @return mixed
     */
    public function toJson()
    {
        return json_decode($this->toArray(), JSON_HEX_AMP);
    }
}
