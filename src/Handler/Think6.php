<?php


/**
 * Class think
 * @author  saber
 * @date  2020/3/17 21:28
 * @version 1.0
 */

namespace Syntony\Handler;

/**
 * tp6 框架处理方法
 * Class Think6
 * @package ErrorTransmitting\Handler
 */
class Think6 extends Handler
{

    /**
     * 错误处理
     * @return bool
     * @throws \ErrorTransmitting\Exception\NotErrorException
     */
    public function handler()
    {
        //检查是否是继承与Exception
        $this->isError($this->error);

        //检测是否属于不需要捕获的异常
        if ($this->error instanceof \think\exception\RouteNotFoundException) {
            return false;
        }
        if ($this->error instanceof \think\db\exception\DbException) {
            $data = $this->error->getData();
            $this->pdoError = $data;
        } else if ($this->error instanceof \think\db\exception\PDOException) {
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
