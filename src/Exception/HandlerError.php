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
    public function page(\Exception $exception)
    {

        $whoops = new Run();
        $whoops->pushHandler($this->drive['page']);
        //阻止直接输出
        $whoops->allowQuit(false);
        //开启缓冲区
        ob_start();
        $whoops->handleException($exception);
        $handler = ob_get_contents();
        //结束缓冲区
        ob_end_clean();
        return $handler;
    }

    /**
     * 将错误结果以错误返回
     * @param \Exception $exception
     * @return false|string
     */
    public function json(\Exception $exception)
    {
        $whoops = new Run();
        $whoops->pushHandler($this->drive['json']);
        //阻止直接输出
        $whoops->allowQuit(false);
        //开启缓冲区
        ob_start();
        $whoops->handleException($exception);
        $handler = ob_get_contents();
        //结束缓冲区
        ob_end_clean();
        return $handler;
    }

}
