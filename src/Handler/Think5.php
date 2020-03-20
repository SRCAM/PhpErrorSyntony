<?php


/**
 * Class think
 * @author  saber
 * @date  2020/3/17 21:28
 * @version 1.0
 */

namespace ErrorTransmitting\Handler;

class Think5 extends Handler
{
    /**
     * 错误处理
     * @return bool
     */
    public function handler()
    {
        $error = $this->error;
        //检测是否属于不需要捕获的异常
        if ($error instanceof \think\exception\RouteNotFoundException) {
            return false;
        }
        //db异常 5.1
        if ($error instanceof \think\Exception\DbException) {
            //db数据库异常
            $data = $error->getData();
            $this->pdoError = $data;
        } else if ($error instanceof \think\db\exception\DbException) {
            //db异常 6.0
            $data = $error->getData();
            $this->pdoError = $data;

        } else if ($error instanceof \think\db\exception\PDOException) {
            $data = $error->getData();
            $this->pdoError = $data;

        } else if ($error instanceof \think\Exception\PDOException) {
            $data = $error->getData();
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
