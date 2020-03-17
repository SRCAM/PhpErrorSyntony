<?php


/**
 * Class handler
 * @author  saber
 * @date  2020/3/17 22:31
 * @version 1.0
 */


namespace ErrorTransmitting\Handler;


use ErrorTransmitting\Exception\NotErrorException;

abstract class handler
{
    /**
     * @var  \Exception 错误类型
     */
    protected $error;

    /**
     * @var array 其他异常错误保存
     */
    protected $otherError;

    protected $visible;

    /**
     * 获取请求数据
     */
    abstract public function getRequest();

    /**
     * 获取返回数据
     */
    abstract public function getResponse();

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
     * 转化为array
     * @return mixed
     */
    public function toArray()
    {
        //将数组转化为
        foreach ($this->error as $key => $val) {
            $this->visible[$key] = $val;
        }
        if (!empty($this->otherError)) {
            array_pop($this->visible, $this->otherError);
        }
        return $this->visible;
    }

    /**
     * 特殊异常处理
     */
    abstract public function handler();

    /**
     * 转化为json
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this->toArray(), JSON_HEX_AMP);
    }

}
