<?php

require_once PROJECT_ROOT_PATH . "/src/utils/SoapWrapper.php";

class BinotifySoapClient
{
    private static $instance;
    private $client;

    private function __construct()
    {
        $opts = array(
            'ssl' => array(
                'ciphers' => 'RC4-SHA',
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        );

        $params = array(
            'encoding' => 'UTF-8',
            'verifypeer' => false,
            'verifyhost' => false,
            'soap_version' => SOAP_1_2,
            'trace' => 1,
            'exceptions' => 1,
            'connection_timeout' => 180,
            'stream_context' => stream_context_create($opts),
        );

        libxml_disable_entity_loader(false); //adding this worked for me
        $this->client = new SoapWrapper($_ENV['WSDL_URL'], $params);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function subscribe($creatorId, $subscriberId)
    {
        $res = $this->client->call("subscribe", array(
            'arg0' => $creatorId,
            'arg1' => $subscriberId,
        ));
        return $res;
    }

    public function getSubscriptions()
    {
        $res = $this->client->call("getSubscriptions", null);
        return $res;
    }

    public function acceptSubscription($creatorId, $subscriptionId)
    {
        $res = $this->client->call("acceptSubscription", array(
            'arg0' => $creatorId,
            'arg1' => $subscriptionId,
        ));
        return $res;
    }

    public function rejectSubscription($creatorId, $subscriptionId)
    {
        $res = $this->client->call("rejectSubscription", array(
            'arg0' => $creatorId,
            'arg1' => $subscriptionId,
        ));
        return $res;
    }

    public function checkStatus($creatorIds, $subscriptionIds) {
        $res = $this->client->call("checkStatus", array(
            'arg0' => $creatorIds,
            'arg1' => $subscriptionIds,
        ));
        return $res;
    }
}
