<?php

class SoapWrapper {
  public function __construct($wsdl) {
    try {
      $this->soapClient = new SoapClient($wsdl,array(
        "exceptions" => 0,
        "trace" => 1,
        "encoding" => "UTF-8",
        'stream_context' => stream_context_create(array(
          'http' => array(
            'header' => 'api-key: ' . $_ENV['API_KEY'],
          ),
        )),
      ));
    } catch (Exception $e) {
      Logger::error("SoapWrapper: Error while creating SoapClient: " . $e->getMessage());
      $this->soapClient = null;
    }
  }

  public function call($functionName, $params) {
    $res = null;

    if (!isset($params)) {
      $res = $this->soapClient->$functionName();
    } else {
      $res = $this->soapClient->$functionName($params);
    }

    return json_encode($res);
  }
}
