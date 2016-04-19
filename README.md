# payleven Point Pay API - PHP SDK

The PaylevenAppApi makes possible for app developers to open the payleven application from within their own apps and process payments. Although the payment is initiated on your app, it is the payleven application that takes care of handling the payment process. After a payment is processed, it will open your app and notify if the payment was successful, canceled or failed. 

### Main Features
- Connects to payleven EMV/PCI certified card reader via bluetooth
- Accept all major card schemes such as Visa, Mastercard or American Express
- Provide immediate information about the payment status 
- Refund card payments
- Supports cash payment method
- Supports all main languages

### Prerequisites
* You or your client is operating in one of the countries supported by payleven.
* You are registered as a regular payleven user in a [payleven country](https://payleven.com/).
* You have signed up and received your API key [here](https://service.payleven.com/uk/developer?product=apppay).
* The iOS or Android payleven app is installed on the mobile device you want to use for accepting card payments.
* A payleven Classic (Chip & PIN) or Plus (NFC) terminal.
* Internet connection and geo location is available in your general use-case

### Installation

This SDK is easily installable via `composer`. If your project does not use composer, download the source from this repo, and include the `autoload.php` file in your application.

`composer require payleven\mobileweb-phpsdk`

#### Usage

##### Instantiate the payleven Object

Use your application's `api_key` and return request configuration to instantiate the Payleven object class.

```php
    $app = new Payleven\Payleven([
        'api_key' => '{your api key}',
        'return_domain' => '{your return domain}',
        'return_page' => '{your return page}',
        'display_name' => '{display name}',
        'return_scheme' => '{return url scheme}',
        'payment_currency' => '{your currency}'
    ]);
```

##### Start A Payment

Start a payment in the Payleven App. This is assuming you've initialized the Payleven object to the `$app` variable:

```php
    $app->startPayment('{payment price in cents}', '{order ID}', '{order description}');

    $app->redirect();

```

The `startPayment` method exposes the generated url as returned in a `string`. If you'd like to handle the redirect on your own, assign that to a variable:

```php
    $url = $app->startPayment('...');
```

Otherwise, you can use the built in `redirect` method to let us handle it.


##### Start A Refund

Start a refund in the Payleven App. This is assuming you've initialized the Payleven object to the `$app` variable:

```php
    $app->startRefund('{order ID}');

    $app->redirect();

```

The `startRefund` method exposes the generated url as returned in a `string`. If you'd like to handle the redirect on your own, assign that to a variable:

```php
    $url = $app->startRefund('...');
```

Otherwise, you can use the built in `redirect` method to let us handle it.

##### Start Transaction Details

Start the Transaction Details for a specific order in the Payleven App. This is assuming you've initialized the Payleven object to the `$app` variable:

```php
    $app->startTransactionDetails('{order ID}');

    $app->redirect();

```

The `startTransactionDetails` method exposes the generated url as returned in a `string`. If you'd like to handle the redirect on your own, assign that to a variable:

```php
    $url = $app->startTransactionDetails('...');
```

Otherwise, you can use the built in `redirect` method to let us handle it.

##### Start Payment History

Start the payment history interface in the Payleven App. This is assuming you've initialized the Payleven object to the `$app` variable:

```php
    $app->startPaymentHistory();

    $app->redirect();

```

The `startPaymentHistory` method exposes the generated url as returned in a `string`. If you'd like to handle the redirect on your own, assign that to a variable:

```php
    $url = $app->startPaymentHistory();
```

Otherwise, you can use the built in `redirect` method to let us handle it.

##### Validate Response

HMAC calculation is used to verify that the response actually came from the intended sender. In order to ensure the data you are receiving to your `retrun` endpoint, you should always validate the response. This also assumes you've initialized the Payleven object to the `$app` variable.

```php
    $valid = $app->validateResponse();


```

This method returns a `boolean` value fo `true` or `false`, depedning upon the validity of the response.

 ##### Accessing the Response Data

 After the mobile API returns it's response to your return endpoint, you can simply access the information via the `$_REQUEST` object. Here is a list of all response fields provided by the Payleven Mobile API:
 ```php
    $responseBody = array(
        'result' => $_REQUEST['result'],
        'description' => $_REQUEST['description'],
        'orderId' => $_REQUEST['orderId'],
        'errorCode' => $_REQUEST['errorCode'],
        'amount' => $_REQUEST['amount'],
        'tipAmount' => $_REQUEST['tipAmount'],
        'currency' => $_REQUEST['currency'],
        'is_duplicate_receipt' => $_REQUEST['is_duplicate_receipt'],
        'payment_method' => $_REQUEST['payment_method'],
        'expire_month' => $_REQUEST['expire_month'],
        'expire_year' => $_REQUEST['expire_year'],
        'effective_month' => $_REQUEST['effective_month'],
        'effective_year' => $_REQUEST['effective_year'],
        'aid' => $_REQUEST['aid'],
        'application_label'	=> $_REQUEST['application_label'],
        'application_preferred_name' => $_REQUEST['application_preferred_name'],
        'pan' => $_REQUEST['pan'],
        'issuer_identification_number' => $_REQUEST['issuer_identification_number'],
        'pan_seq' => $_REQUEST['pan_seq'],
        'card_scheme' => $_REQUEST['card_scheme'],
        'bank_code'	=> $_REQUEST['bank_code'],
        'pos_entry_mode' => $_REQUEST['pos_entry_mode'],
        'merchant_id' => $_REQUEST['merchant_id'],
        'merchant_display_name' => $_REQUEST['merchant_display_name'],
        'auth_code' => $_REQUEST['auth_code'],
        'terminal_id' => $_REQUEST['terminal_id'],
        'api_version' => $_REQUEST['api_version'],
        'timestamp' => $_REQUEST['timestamp']
    );

 ```

 Then, you can simply access the data form the `$responseBody` array. You can, of course, interact with the `$_REQUEST` object in any way that suits your application best.
