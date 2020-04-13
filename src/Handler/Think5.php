<?php


/**
 * Class think
 * @author  saber
 * @date  2020/3/17 21:28
 * @version 1.0
 */

namespace Syntony\Handler;

/**
 * tp5 框架处理方法
 * Class Think5
 * @package ErrorTransmitting\Handler
 */
class Think5 extends Handler
{

    /**
     * @inheritDoc
     */
    protected function getParam()
    {
        return \request()->param();
    }

    protected function getUrl()
    {
        return \request()->url();
    }

    protected function getMethod()
    {
        return \request()->method();
    }

    protected function getCookie()
    {
        return \request()->cookie();
    }

    protected function getHeader()
    {
        return \request()->header();
    }

    /**
     * @inheritDoc
     */
    protected function selfHandler()
    {
        //检测是否属于不需要捕获的异常
        if ($this->error instanceof \think\exception\RouteNotFoundException) {
            return false;
        }
        //db异常 5.1
        if (
            $this->error instanceof \think\Exception\DbException
            || $this->error instanceof \think\Exception\PDOException
        ) {
            //db数据库异常
            $this->pdoError = $this->error->getData();
        }
        //同一消息处理
        return true;
    }
}
