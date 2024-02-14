<?php

/**
 * Tattonote v0.5 Public Preview
 * Based on DBMotion 1.2.0
 * 
 * @author Diamochang (Mike Wang) <diamochang@skiff.com>
 * @copyright Copyright (C) Diamochang (Mike Wang), 2024.
 * @license Apache-2.0
 */

namespace core;
date_default_timezone_set("Asia/Shanghai");  //用于预览公网

class Engine
{
    protected $debug;

    public function __construct($debug = true)
    {
        $this->debug = $debug;
    }

    public function error()
    {
        error_reporting(0);
        set_error_handler([$this, 'handle'], E_ALL | E_STRICT);
    }

    public function handle($code)
    {
        //错误处理主程序
        $error_file = 'logs/' . date("Y_m_d") . '.log';
        $advice_file = 'logs/' . date("Y_m_d") . '_advice.log';
        $logmsg = date("[c]") . $php_errormsg . PHP_EOL;
        $errorpage = <<<HTML
        <!DOCTYPE html>
        <html lang="zh-CN" class="mdui-theme-auto">
        
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
            <meta name="renderer" content="webkit" />
            <meta name="force-rendering" content="webkit" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
            <link rel="stylesheet" href="https://unpkg.com/mdui@2.0.3/mdui.css" />
            <script src="https://unpkg.com/mdui@2.0.3/mdui.global.js"></script>
            <title>哦豁 - Tattonote</title>
        </head>
        
        <body>
            <mdui-layout>
                <mdui-layout-main>
                    <mdui-card>
                        <div class="mdui-prose">
                            <div>
                                <h2>哦豁...</h2>
                                <p>Tattonote 发生了致命错误。如果你是访客，请过会时间再试或者向网站管理员报告。如果你是开发者，请立即查看日志并排除错误。</p>
                            </div>
                        </div>
                        <mdui-button variant="filled" onclick="javascript:location.reload()">刷新</mdui-button>
                        <mdui-dialog close-on-overlay-click class="info-headline-slot">
                            <span slot="headline">可提供信息</span>
                            <span slot="description">报告错误时，可以提供以下信息。<br />错误触发时间：' . date("c") . '</span>
                        </mdui-dialog>
                        <mdui-button variant="tonal" class="info-trigger">查看可提供信息</mdui-button>
                    <script>
                        const dialog = document.querySelector(".info-headline-slot");
                        const openButton = dialog.nextElementSibling;

                        openButton.addEventListener("click", () => dialog.open = true);
                    </script>
                    </mdui-card>
                </mdui-layout-main>
            </mdui-layout>
        </body>
        
        </html>
        HTML;
        switch ($code) {
                //以下三个均为建议类错误，归到专门的日志中
            case E_NOTICE:
            case E_WARNING:
            case E_STRICT:
                if ($this->debug) {
                    echo $php_errormsg;
                } else {
                    error_log($logmsg, 3, $advice_file);
                }
                break;
            //Fatal error 直接抛哦豁页
            case E_ERROR:
            case E_RECOVERABLE_ERROR:
                if ($this->debug) {
                    echo $php_errormsg;
                    echo $errorpage;
                } else {
                    error_log($logmsg, 3, $error_file);
                    echo $errorpage;
                }
                die;
                //其它错误仅记录，程序继续运行
            default:
                if ($this->debug) {
                    echo $php_errormsg;
                } else {
                    //其他错误均归到普通日志中
                    error_log($logmsg, 3, $error_file);
                }
                break;
        }
    }
}
