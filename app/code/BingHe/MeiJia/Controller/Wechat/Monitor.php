<?php

namespace BingHe\MeiJia\Controller\Wechat;

class Monitor extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        // Message Handler
        $this->_objectManager->get('BingHe\MeiJia\Helper\Wechat')->messageHandler();
    }
}
