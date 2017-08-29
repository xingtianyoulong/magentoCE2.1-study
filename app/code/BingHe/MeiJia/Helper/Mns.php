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
    public $endPoint = 'http://1222093724820448.mns.cn-hangzhou.aliyuncs.com/';
    public $accessId = 'LTAIV3NGP8e0a2Hp';
    public $accessKey = 'b3as5nuYfAi05wVUE9DwZuMy4MXcef';

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
