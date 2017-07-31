<?php

namespace BingHe\MeiJia\Controller\Api;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Customer extends \Magento\Framework\App\Action\Action
{
    /**
     * Init
     * 
     * @param $context
     * @param $jsonFactory
     *
     * @return Void
     */
    public function __construct(Context $context, JsonFactory $jsonFactory) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute() {
        // Json Factory
        $jsonFactory = $this->jsonFactory->create();

        // Reponse Array
        $response = [];

        // Code
        $response['errcode'] = 0;

        // Msg
        $response['errmsg'] = 'ok';

        // Content
        $response['content'] = [
            'user_id' => 1,
            'user_name' => 'MeiJia',
            'images' => [
                'http://www.91ljj.com/media/catalog/product/cache/image/1000x1320/e9c3970ab036de70892d86c6d221abfe/d/0/d0001_1.jpg',
                'http://www.91ljj.com/media/catalog/product/cache/image/1000x1320/e9c3970ab036de70892d86c6d221abfe/c/0/c0009.jpg'
            ]
        ];

        // Return
        return $jsonFactory->setData($response);
    }
}
