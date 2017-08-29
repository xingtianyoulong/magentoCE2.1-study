<?php

namespace BingHe\MeiJia\Controller\Api;

class Captcha extends \Magento\Framework\App\Action\Action
{
    /**
     * Printing
     *
     * @return Void
     */
    public function execute() {
        // Json Factory
        $jsonFactory = $this->_objectManager->get('Magento\Framework\Controller\Result\JsonFactory')->create();

        // Mobile
        $mobile = $this->getRequest()->getParam('mobile');

        // Rand Number
        $captcha = rand(100000, 999999);

        // Save Session
        $this->_objectManager->get('Magento\Customer\Model\Session')->setMobile($mobile);
        $this->_objectManager->get('Magento\Customer\Model\Session')->setCaptcha($captcha);

        // Reponse Array
        $response = [];

        // Code
        $response['errcode'] = 0;

        // Msg
        $response['errmsg'] = 'ok';

        // If $mobile Is Invalid
        if (!$mobile || strlen($mobile) != 11) {
            // Code
            $response['errcode'] = 40001;

            // Msg
            $response['errmsg'] = '请输入正确的手机号码！';

            // Return
            return $jsonFactory->setData($response);
        }

        // SMS Message
        $this->_objectManager->get('BingHe\MeiJia\Helper\Sms')->sendMessage('您的验证码是' . $captcha, $mobile);

        // Return
        return $jsonFactory->setData($response);
    }
}
