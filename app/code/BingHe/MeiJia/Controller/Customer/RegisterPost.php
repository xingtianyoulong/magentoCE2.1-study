<?php

namespace BingHe\MeiJia\Controller\Customer;

class RegisterPost extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        // Init Params
        $openId = $this->getRequest()->getParam('open_id');
        $mobile = $this->getRequest()->getParam('mobile');
        $captcha = $this->getRequest()->getParam('captcha');
        $sessionMobile = $this->_objectManager->get('Magento\Customer\Model\Session')->getMobile();
        $sessionCaptcha = $this->_objectManager->get('Magento\Customer\Model\Session')->getCaptcha();

        // Json Factory
        $jsonFactory = $this->_objectManager->get('Magento\Framework\Controller\Result\JsonFactory')->create();

        // Reponse Array
        $response = [];

        // Code
        $response['errcode'] = 0;

        // Msg
        $response['errmsg'] = 'ok';

        // Check Open Id
        if (!$openId) {
            // Code
            $response['errcode'] = 40003;

            // Msg
            $response['errmsg'] = '请用使用微信扫码后注册！';

            // Return
            return $jsonFactory->setData($response);
        }

        // Check Mobile & Captcha
        if (!$mobile || $mobile != $sessionMobile || !$captcha || $captcha != $sessionCaptcha) {
            // Code
            $response['errcode'] = 40002;

            // Msg
            $response['errmsg'] = '请输入正确的手机号和验证码！';

            // Return
            return $jsonFactory->setData($response);
        }

        // Create Customer
        $this->_objectManager->get('BingHe\MeiJia\Helper\Customer')->create($mobile, $openId);

        // Return
        return $jsonFactory->setData($response);
    }
}
