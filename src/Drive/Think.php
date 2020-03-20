<?php


namespace ErrorTransmitting\Exception;

use think\App;

class Think implements DriveInterFace
{
    private $version;
    private $pre_ = 'Think';

    public function getVersion()
    {
        return $this->version;
    }

    public function loade($class)
    {
        //获取app的版本
        $this->version = (int)$class->version();
        //判断框架是否
        $classSpace = __NAMESPACE__ . '\\Handler\\' . ucfirst($this->pre_ . $this->version);
        //如果类型不存在
        if (class_exists($classSpace)) {
            throw new HandlerNotFindException($classSpace . ':not find');
        }
        $class = new $classSpace();
        return $class;
    }
}