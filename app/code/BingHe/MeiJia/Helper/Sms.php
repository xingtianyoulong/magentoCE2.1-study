<?php

namespace BingHe\MeiJia\Helper;

/**
 * SMS Helper
 */
class Sms extends \Magento\Framework\App\Helper\AbstractHelper
{
    // Global Params
    public $username = 'yikevip';
    public $pwd = 'As045180';

    /**
     * Send Message
     * 
     * @return Boolean
     */
    public function sendMessage($content, $mobile)
    {
        // 请求URL
        $url = "http://222.73.117.158/msg/HttpBatchSendSM?";
        
        // 格式化请求参数
        $param = http_build_query(
            array(
                'account'=>$this->username,
                'pswd'=>$this->pwd,
                'mobile'=>$mobile,
                'msg'=>iconv("UTF-8","UTF-8", $content),
                'needstatus'=>'true'
            )
        );
        
        // 模拟POST请求
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
