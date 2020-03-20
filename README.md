# ErrorTransmitting php 多框架错误捕获系统

![PHP from Packagist](https://img.shields.io/packagist/php-v/saber/error-transmitting)
![Packagist Version](https://img.shields.io/packagist/v/saber/error-transmitting)
![THINKPHP](https://img.shields.io/badge/-thinkphp-brightgreeng)
##介绍
* 支持php7 以上框架 ,现目前已经支持thinkphp5以上
* 支持提交到指定服务器
* 支持将错误保存到本地
* 支持邮箱通知
* 展不支持异步框架
## 安装
* 保存到你的项目中的composer.json 文件
``
"phpmailer/phpmailer": "~6.1"
``
	或者
	```sh
	composer require phpmailer/phpmailer
	```
	
## 使用方法
#### thinkphp
```php
<?php


namespace app\common;


use ErrorTransmitting\Factory;
use think\exception\Handle;
use Exception;
use think\exception\HttpException;
use think\exception\ValidateException;

class ExceptionHandle extends Handle
{
    public function render(Exception $e)
    {
        /**
         * @var array 配置文件
         */
        $config = [

            'http' => [
                'url' => 'https://baidu.com',
                'method' => 'post'
            ],

            'emall' => [

            ]
        ];
		//调用错误发送方法
        Factory::create($config)->handler($e)->http();
        // 其他错误交给系统处理
        return parent::render($e);
    }
}
	```