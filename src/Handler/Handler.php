<?php


/**
 * Class handler
 * @author  saber
 * @date  2020/3/17 22:31
 * @version 1.0
 */


namespace ErrorTransmitting\Handler;


use ErrorTransmitting\Exception\NotErrorException;

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
    abstract public function getResponse();
    abstract public function getUrl();
    abstract public function getCookie();
    abstract public function getHeader();
    public function __construct($error)
    {
        $this->error = $error;
        //检查是否是异常类
        $this->isError($this->error);
    }

    /**
     * 判断是否是异常类
     * @param $error
     * @throws NotErrorException
     */
    protected function isError($error)
    {

        if (!is_callable(array($error, 'getMessage'))) {
            throw new NotErrorException('this class not !Exception');
        }

        if (!is_callable(array($error, 'getCode'))) {
            throw new NotErrorException('this class not !Exception');
        }

        if (!is_callable(array($error, 'getCode'))) {
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
        return $this->error->getCode();
    }

    public function getLine()
    {
        return $this->error->getLine();
    }

    public function getMessage()
    {
        return $this->error->getMessage();
    }

}
