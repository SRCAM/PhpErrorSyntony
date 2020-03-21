<?php


namespace Syntony\Drive;

use Syntony\Exception\HandlerNotFindException;
use Syntony\Handler\Think5;
use Syntony\Handler\Think6;

class Think implements DriveInterFace
{
    private $Handler = [
        'Think5' => Think5::class,
        'Think6' => Think6::class,
    ];
    private $version; //框架版本号
    private $pre_ = 'Think'; //框架别名

    /**
     * 加载方法
     * @param $class
     * @return mixed
     * @throws HandlerNotFindException
     */
    public function load($class)
    {
        //获取app的版本
        $this->version = (int)(new $class)->version();
        if (!isset($this->Handler[$this->pre_ . $this->version])) {
            throw new HandlerNotFindException($this->pre_ . ':not find by' . $this->version . 'version');
        } else {
            $classSpace = $this->Handler[$this->pre_ . $this->version];
        }
        $class = new $classSpace();
        return $class;
    }
}
