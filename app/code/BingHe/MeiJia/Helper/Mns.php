<?php

namespace BingHe\MeiJia\Helper;

use AliyunMNS\Client;
use AliyunMNS\Requests\SendMessageRequest;
use AliyunMNS\Requests\CreateQueueRequest;
use AliyunMNS\Exception\MnsException;

/**
 * MNS Helper
 */
class Mns extends \Magento\Framework\App\Helper\AbstractHelper
{
    // Global Params
    public $endPoint = '';
    public $accessId = '';
    public $accessKey = '';

    /**
     * Send Message
     * 
     * @return Boolean
     */
    public function sendMessage($queueRef, $msg)
    {
        // Client
        $this->client = new Client($this->endPoint, $this->accessId, $this->accessKey);

        // Queue
        $queue = $this->client->getQueueRef($queueRef);

        // Request
        $request = new SendMessageRequest($msg);

        // Try Catch
        try {
            // Send Success
            $queue->sendMessage($request);
        } catch (MnsException $e) {
            // Error
            return false;
        }

        // Return
        return true;
    }
}
