<?php

namespace BingHe\MeiJia\Controller\Api;

class Printing extends \Magento\Framework\App\Action\Action
{
    /**
     * Printing
     *
     * @return Void
     */
    public function execute() {
        // Init Params
        $openId = $this->getRequest()->getParam('open_id');
        $qrcode = $this->getRequest()->getParam('qrcode');

        // Customer
        $customer = $this->_objectManager->get('BingHe\MeiJia\Helper\Customer')->loadByOpenId($openId);

        // Send Message To MNS
        $this->_objectManager->get('BingHe\MeiJia\Helper\Mns')->sendMessage($qrcode, $customer->getId());
    }
}
