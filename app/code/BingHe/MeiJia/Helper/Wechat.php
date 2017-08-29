<?php

namespace BingHe\MeiJia\Helper;

use EasyWeChat\Foundation\Application;

/**
 * Wechat Helper
 */
class Wechat extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Init
     * 
     * @return Void
     */
    public function __construct()
    {
        // Init Params
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * Options
     * 
     * @return Array
     */
    public function getOptions()
    {
        return [
            /**
             * Debug 模式，bool 值：true/false
             *
             * 当值为 false 时，所有的日志都不会记录
             */
            'debug'  => true,

            /**
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
            'app_id'  => 'wx5d9a3f74469ba413', // AppID
            'secret'  => 'ce45ecd31ff056af0975ad1fb4ca8293', // AppSecret
            'token'   => '91jj', // Token
            'aes_key' => 'yorsPEkq8ZHhmfcWyIRsMfGckSzMIs0jUWanGo4AJ2O', // EncodingAESKey，安全模式下请一定要填写！！！

            /**
             * 日志配置
             *
             * level: 日志级别, 可选为：
             *         debug/info/notice/warning/error/critical/alert/emergency
             * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
             * file：日志文件位置(绝对路径!!!)，要求可写权限
             */
            'log' => [
                'level'      => 'debug',
                'permission' => 0777,
                'file'       => '../var/log/easywechat.log',
            ],

            /**
             * OAuth 配置
             *
             * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
             * callback：OAuth授权完成后的回调页地址
             */
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => '/examples/oauth_callback.php',
            ],

            /**
             * 微信支付
             */
            'payment' => [
                'merchant_id'        => 'your-mch-id',
                'key'                => 'key-for-signature',
                'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
                'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
                // 'device_info'     => '013467007045764',
                // 'sub_app_id'      => '',
                // 'sub_merchant_id' => '',
                // ...
            ],

            /**
             * Guzzle 全局设置
             *
             * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
             */
            'guzzle' => [
                'timeout' => 3.0, // 超时时间（秒）
                //'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
            ],
        ];
    }

    /**
     * Message Handler
     * 
     * @return String
     */
    public function messageHandler()
    {
        // Options
        $options = $this->getOptions();

        // App
        $app = new Application($options);

        // Server
        $server = $app->server;

        // Message Handler
        $server->setMessageHandler(function ($message) {
            // $message 不仅仅是用户发来的消息，当 $message->MsgType 为 event 时为事件
            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                    case 'SCAN':
                        return $this->messageNotice($message);
                    break;
                }
            }
        });

        // Response
        $response = $server->serve();
        $response->send();
    }

    /**
     * Message Notice
     * 
     * @return String
     */
    public function messageNotice($message)
    {
        // Init Params
        $openId = $message->FromUserName;
        $qrcode = str_replace('qrscene_', '', $message->EventKey);

        // Customer
        $customer = $this->_objectManager->get('BingHe\MeiJia\Helper\Customer')->loadByOpenId($openId);

        // If Customer Not Exist
        if (!$customer->getId()) {
            // Return
            return '您还未注册成为我们的用户，请点击<a href="http://www.91ljj.com/customer/account/create?open_id=' . $openId . '">此处注册。</a>';
        }

        // Return
        return '是否需要在这台美甲机上彩绘？如需立即打印，请点击<a href="http://www.91ljj.com/meijia/api/printing?open_id=' . $openId . '&qrcode=' . $qrcode . '">当前链接继续。</a>';
    }

    /**
     * Create Qrcode
     * 
     * @return String
     */
    public function createQrcode()
    {
        $options = $this->getOptions();

        $app = new Application($options);
        $qrcode = $app->qrcode;

        $result = $qrcode->forever('BFEBFBFF000306C30000000000000000');
        $ticket = $result->ticket;

        $url = $qrcode->url($ticket);

        return $url;
    }

    /**
     * Validation Response
     * 
     * @return String
     */
    public function sendValidationResponse()
    {
        $options = $this->getOptions();

        $app = new Application($options);
        $response = $app->server->serve();

        return $response->send();
    }
}
