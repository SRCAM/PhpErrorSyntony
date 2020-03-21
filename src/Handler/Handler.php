<?php


/**
 * Class handler
 * @author  saber
 * @date  2020/3/17 22:31
 * @version 1.0
 */


namespace Syntony\Handler;


use Syntony\Exception\NotErrorException;


/**
 * 处理方法的基类
 * Class Handler
 * @package ErrorTransmitting\Handler
 */
abstract class Handler
{
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
    abstract public function getParam();

    /**
     * 特殊异常处理
     */
    abstract public function handler();

    /**
     * 获取返回数据
     * @return mixed
     */
    abstract public function getResponse();

    /**
     * 获取url 地址
     * @return mixed
     */
    abstract public function getUrl();

    /**
     * 获取cookie
     * @return mixed
     */
    abstract public function getCookie();

    /**
     * 获取请求头
     * @return mixed
     */
    abstract public function getHeader();

    /**
     * 获取
     * @return mixed
     */
    abstract public function getMethod();

    public function __construct($error = [])
    {
        $this->error = $error;
        //检查是否是异常类
    }

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

    /**
     * 返回错误信息
     * @return array array
     */
    public function getPdoError()
    {
        return $this->pdoError;
    }

    /**
     * 获取文件名称
     * @return string
     */
    public function getFile()
    {
        return $this->error->getFile();
    }

    /**
     * 错误code
     * @return int|mixed
     */
    public function getCode()
    {
        return $this->error->getCode() ? $this->error->getCode() : 500;
    }

    /**
     * @return int
     */
    public function getLine()
    {
        return $this->error->getLine();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->error->getMessage();
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
     * 获取接送数据
     * @return mixed
     */
    public function toJson()
    {
        return json_decode($this->toArray(), JSON_HEX_AMP);
    }

}
