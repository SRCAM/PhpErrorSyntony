<?php


/**
 * Class HandlerError
 * @author  saber
 * @date  2020/3/21 15:22
 * @version 1.0
 */


namespace syntony\Exception;

use Whoops\Run;

class HandlerError
{
    //同一处理方法
    private $drive = [
        'page' => \Whoops\Handler\PrettyPageHandler::class,
        'json' => \Whoops\Handler\JsonResponseHandler::class
    ];

    /**
     * @var \Whoops\Run Run
     */
    private $whoops;

    public function __construct()
    {
        $this->whoops = new Run();
    }

    /**
     * @param \Exception $exception
     * @param string $show
     * @return false|string
     */
    public function page($exception)
    {


        $this->whoops->pushHandler(new $this->drive['page'] );
        //阻止直接输出
        $this->whoops->allowQuit(false);
        $this->whoops->sendHttpCode();
        //开启缓冲区
        ob_start();
        $this->whoops->handleException($exception);
        ob_end_clean();
        $handler = ob_get_contents();
        //结束缓冲区
        return $handler;
    }

    /**
     * 将错误结果以错误返回
     * @param \Exception $exception
     * @return false|string
     */
    public function json( $exception)
    {
        $this->whoops->pushHandler(new $this->drive['json'] );
        //阻止直接输出
        $this->whoops->allowQuit(false);
        //开启缓冲区
        ob_start();
        $this->whoops->handleException($exception);
        $handler = ob_get_contents();
        //结束缓冲区
        ob_end_clean();
        return $handler;
    }

}
