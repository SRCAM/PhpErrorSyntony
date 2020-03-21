<?php


namespace Syntony\Handler;


/**
 * 其他框架通用处理方法
 * Class Other
 * @package ErrorTransmitting\Handler
 */
class Other extends Handler
{

    /**
     * @inheritDoc
     */
    public function getParam()
    {
        return array_merge($_POST, $_GET);
    }


    /**
     * @inheritDoc
     */
    public function getUrl()
    {

        return $this->getCurUrl();
    }

    /**
     * @inheritDoc
     */
    public function getCookie()
    {
        return $_COOKIE;
    }

    /**
     * @inheritDoc
     */
    public function getHeader()
    {
        return $this->getHeaders();
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * 后去请求头
     * @return mixed
     */
    private function getHeaders()
    {
        foreach ($_SERVER as $key => $value) {
            if ('HTTP_' == substr($key, 0, 5)) {
                $headers[str_replace('_', '-', substr($key, 5))] = $value;
            }
            if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
                $header['AUTHORIZATION'] = $_SERVER['PHP_AUTH_DIGEST'];
            } elseif (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                $header['AUTHORIZATION'] = base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW']);
            }
            if (isset($_SERVER['CONTENT_LENGTH'])) {
                $header['CONTENT-LENGTH'] = $_SERVER['CONTENT_LENGTH'];
            }
            if (isset($_SERVER['CONTENT_TYPE'])) {
                $header['CONTENT-TYPE'] = $_SERVER['CONTENT_TYPE'];
            }
        }
        return $headers;
    }

    private function getCurUrl()
    {
        $url = 'http://';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $url = 'https://';
        }

        // 判断端口
        if ($_SERVER['SERVER_PORT'] != '80') {
            $url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . ':' . $_SERVER['REQUEST_URI'];
        } else {
            $url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['REQUEST_URI'];
        }

        return $url;
    }

    /**
     * @inheritDoc
     */
    protected function selfHandler()
    {
        return true;
    }
}
