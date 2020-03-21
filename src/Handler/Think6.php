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
     * 程序自我处理
     * @return bool
     */
    protected function selfHandler()
    {
        //检测是否属于不需要捕获的异常
        if ($this->error instanceof \think\exception\RouteNotFoundException) {
            return false;
        }
        if (
            $this->error instanceof \think\db\exception\PDOException
            || $this->error instanceof \think\db\exception\DbException
        ) {
            $this->pdoError = $this->error->getData();
        }
        //同一消息处理
        return true;
    }
}
