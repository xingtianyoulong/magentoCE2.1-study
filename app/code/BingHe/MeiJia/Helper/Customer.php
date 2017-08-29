<?php

namespace BingHe\MeiJia\Helper;

/**
 * Customer Helper
 */
class Customer extends \Magento\Framework\App\Helper\AbstractHelper
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
     * Create Customer
     * 
     * @return Customer
     */
    public function create($mobile, $openId)
    {
        // Customer
        $customer = $this->_objectManager->create('Magento\Customer\Model\Customer')->getCollection()
            ->addAttributeToFilter([
                ['attribute' => 'mobile', 'eq' => $mobile],
                ['attribute' => 'open_id', 'eq' => $openId]
            ])
            ->getFirstItem();

        // Set Data
        $customer->setEmail($mobile . '@default.com');
        $customer->setFirstname($mobile);
        $customer->setLastname($mobile);
        $customer->setMobile($mobile);
        $customer->setOpenId($openId);
        $customer->setPassword($mobile);

        // Save
        $customer->setConfirmation(null)->save();

        // Login
        $this->_objectManager->get('Magento\Customer\Model\Session')->setCustomerAsLoggedIn($customer);

        // Return
        return $customer;
    }

    /**
     * Load By Open Id
     * 
     * @return Customer
     */
    public function loadByOpenId($openId)
    {
        // Customer
        $customer = $this->_objectManager->create('Magento\Customer\Model\Customer')->getCollection()
            ->addAttributeToFilter('open_id', $openId)
            ->getFirstItem();

        // Return
        return $customer;
    }
}
