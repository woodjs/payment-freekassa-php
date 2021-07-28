# payment-freekassa

## Пример использования класса

```php
<?php
require './Freekassa.php';

$merchant_id = 123;
$secret_word = 'word1';
$secret_word2 = 'word2';

$freekassa = new FreeKassa($merchant_id, $secret_word, $secret_word2);
```
