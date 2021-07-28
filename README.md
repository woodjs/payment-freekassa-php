# payment-freekassa

## Пример использования класса new FreeKassa

```php
<?php
require './Freekassa.php';

$merchant_id = 123;
$secret_word = 'word1';
$secret_word2 = 'word2';

$freekassa = new FreeKassa($merchant_id, $secret_word, $secret_word2);
```
## Объявление суммы и идентификатора заказа setUp
```php
$amount = 100;
$order_id = 1;
$freekassa->setUp($amount, $sum);
```
## Генерация цифровой подписи для оформления заказа getSignature
```php
//...
$amount = 100;
$order_id = 1;

$freekassa->setUp($amount, $sum);

$sign = $freekassa->getSignature();
```
## Генерация цифровой подписи для проверки платежа getOrderSignature
```php
//...
$amount = $_REQUEST['ANOUNT'];
$order_id = $_REQUEST['MERCHANT_ORDER_ID'];

$freekassa->setUp($amount, $sum);

$sign = $freekassa->getOrderSignature();

if ($sign != $_REQUEST['SIGN']) die('wrong sign');
```

## Генерация ссылки для оплаты generateUrlPayment
По умолчанию функция generateUrlPayment принимает в качестве параметра цифровую подпись, которая необязательная, но для тестирования может пригодится. <br>
Пример без цифровой подписи:
```php
//...
$amount = 100;
$order_id = 1;

$freekassa->setUp($amount, $sum);

$url = $freekassa->generateUrlPayment(); 
```
Пример с передачей цифровой подписи
```php
//...
$amount = 100;
$order_id = 1;

$freekassa->setUp($amount, $sum);

$sign = $freekassa->getSignature();
$url = $freekassa->generateUrlPayment($sign); 
```

## Получение информаций об объявленным переменных в классе getInfo
Функция возвращает JSON данные: merchantId, secretWord, desecretWord, currency, sum, orderId
```php
//...
$data = $freekassa->getInfo();
echo $data;
```

## Ошибки
Каждая функция проверят все нужные объявленные переменные в классе, если один из них равен null или false будет возвращаена ошибка;<br>
Пример 1: 
```php
//...

$freekassa = new FreeKassa(null, 'secret1', 'secret2');

echo $freekassa->generateUrlPayment(); 
// return {"ok":false,"message":"merchant_id not declared"}
```
Пример 2: 
```php
//...

$freekassa = new FreeKassa(123, 'secret1', 'secret2');

echo $freekassa->generateUrlPayment(); 
// return {"ok":false,"message":"order_id not declared. Call the setUp function"}
```
