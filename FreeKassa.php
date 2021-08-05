<?php

class FreeKassa {
  const URL = 'https://pay.freekassa.ru/';

  public $sum = 0;
  public $order_id = null;

  public function __construct($merchant_id, $secret_word, $desecret_word, $currency = 'RUB') {
    $this->merchant_id = $merchant_id;
    $this->secret_word = $secret_word;
    $this->desecret_word = $desecret_word;
    $this->currency = $currency;
  }

  public function checkError() {
    if (!$this->merchant_id) return ['ok' => false, 'message' => 'merchant_id not declared'];
    if (!$this->secret_word) return ['ok' => false, 'message' => 'secret_word not declared'];
    if (!$this->desecret_word) return ['ok' => false, 'message' => 'desecret_word not declared'];
    if (!$this->order_id) return ['ok' => false, 'message' => 'order_id not declared. Call the setUp function'];

    return ['ok' => true, 'message' => 'count errors: 0'];
  }

  public function getInfo() {
    return json_encode([
      'merchantId' => $this->merchant_id,
      'secret' => $this->secret_word,
      'desecret' => $this->desecret_word,
      'currency' => $this->currency,
      'sum' => $this->sum,
      'orderId' => $this->order_id,
    ]);
  }

  public function setUp($sum, $order_id){
    $this->sum = $sum;
    $this->order_id = $order_id;
  }

  public function getSignature() {
    $error = $this->checkError();

    if (!$error['ok']) return json_encode($error); 
  
    return md5($this->merchant_id . ':' . $this->sum . ':' . $this->secret_word . ':' . $this->currency . ':' . $this->order_id);
  }

  public function getOrderSignature() {
    $error = $this->checkError();

    if (!$error['ok']) return json_encode($error); 
  
    return md5($this->merchant_id . ':' . $this->sum . ':' . $this->desecret_word . ':' . $this->order_id);
  }

  public function generateUrlPayment($signature = null) {
    $error = $this->checkError();

    if (!$error['ok']) return json_encode($error); 

    return self::URL . '?' . http_build_query([
      'm' => $this->merchant_id,
      'oa' => $this->sum,
      'o' => $this->order_id,
      's' => $this->getSignature(),
      'currency' => $this->currency,
    ]);
  }
}