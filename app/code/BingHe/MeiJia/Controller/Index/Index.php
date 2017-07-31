<?php

namespace BingHe\MeiJia\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $token = $this->_objectManager->get('BingHe\MeiJia\Helper\Wechat')->getToken();

        var_dump($token);

        /**
        $object_manager = \Magento\Core\Model\ObjectManager::getInstance(); // \Magento\Framework\App\ObjectManager::getInstance();
        $helper_factory = $object_manager->get('\Magento\Core\Model\Factory\Helper');
        $helper = $helper_factory->get('\Magento\Core\Helper\Data');
        */

        /**
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
        */
    }
}
