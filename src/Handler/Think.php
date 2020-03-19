<?php


/**
 * Class think
 * @author  saber
 * @date  2020/3/17 21:28
 * @version 1.0
 */

namespace ErrorTransmitting\Handler;

class Think extends handler
{

    //处理
    public function handler()
    {
        $error = $this->error;
        //检测是否属于不需要捕获的异常
        if ($error instanceof think\exception\RouteNotFoundException) {
            return false;
        }
        //db异常 5.1
        if ($error instanceof think\Exception\DbException) {
            //db数据库异常
            $data = ($error->getData())['Database Status'];
            $this->otherError = is_array($data) ? json_encode($data, JSON_HEX_AMP) : $data;
        } else if ($error instanceof think\db\exception\DbException) {
            //db异常 6.0
            $data = ($error->getData())['Database Status'];
            $this->otherError = $data ? json_encode($data, JSON_HEX_AMP) : $data;

        } else if ($error instanceof think\db\exception\PDOException) {
            $data = ($error->getData())['PDO Error Info'];
            $this->otherError = $data ? json_encode($data, JSON_HEX_AMP) : $data;

        } else if ($error instanceof think\Exception\PDOException) {
            $data = ($error->getData())['PDO Error Info'];
            $this->otherError = $data ? json_encode($data, JSON_HEX_AMP) : $data;
        }
        //同一消息处理
        return true;
    }
    /**
     * @inheritDoc
     */
    public function getParam()
    {
        return request()->param();
    }
    /**
     * @inheritDoc
     */
    public function getResponse()
    {
       return  response()->getData();
    }

}
