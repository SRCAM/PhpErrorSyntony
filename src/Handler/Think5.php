<?php


/**
 * Class think
 * @author  saber
 * @date  2020/3/17 21:28
 * @version 1.0
 */

namespace ErrorTransmitting\Handler;

/**
 * tp5 框架处理方法
 * Class Think5
 * @package ErrorTransmitting\Handler
 */
class Think5 extends Handler
{

    /**
     * 错误处理
     * @return bool
     * @throws \ErrorTransmitting\Exception\NotErrorException
     */
    public function handler()
    {
        $this->isError($this->error);
        //检测是否属于不需要捕获的异常
        if ($this->error instanceof \think\exception\RouteNotFoundException) {
            return false;
        }
        //db异常 5.1
        if ($this->error instanceof \think\Exception\DbException) {
            //db数据库异常
            $data = $this->error->getData();
            $this->pdoError = $data;
        } else if ($this->error instanceof \think\Exception\PDOException) {
            $data = $this->error->getData();
            $this->pdoError = $data;
        }
        //同一消息处理
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getParam()
    {
        return \request()->param();
    }

    /**
     * @inheritDoc
     */
    public function getResponse()
    {
        $hd = new \think\exception\Handle();
        $erorrRender = $hd->render($this->error);
        return $erorrRender->getData();
    }

    public function getUrl()
    {
        return \request()->url();
    }

    public function getMethod()
    {
        return \request()->method();
    }

    public function getCookie()
    {
        return \request()->cookie();
    }

    public function getHeader()
    {
        return \request()->header();
    }
}
