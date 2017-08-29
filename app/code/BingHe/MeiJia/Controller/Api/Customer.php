<?php

namespace BingHe\MeiJia\Controller\Api;

class Customer extends \Magento\Framework\App\Action\Action
{
    /**
     * Customer Info
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute() {
        // Json Factory
        $jsonFactory = $this->_objectManager->get('Magento\Framework\Controller\Result\JsonFactory')->create();

        // Reponse Array
        $response = [];

        // Code
        $response['errcode'] = 0;

        // Msg
        $response['errmsg'] = 'ok';

        // Content
        $response['content'] = [
            'id' => 1,
            'name' => 'MeiJia',
            'images' => [
                'http://www.91ljj.com/media/catalog/product/cache/image/1000x1320/e9c3970ab036de70892d86c6d221abfe/d/0/d0001_1.jpg',
                'http://www.91ljj.com/media/catalog/product/cache/image/1000x1320/e9c3970ab036de70892d86c6d221abfe/c/0/c0009.jpg'
            ]
        ];

        // Return
        return $jsonFactory->setData($response);
    }
}
