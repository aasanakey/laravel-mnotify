# Laravel Mnotify Sms Api
[![GitHub issues](https://img.shields.io/github/issues/SanakeyAugustineAyiku/laravel-mnotify)](https://github.com/SanakeyAugustineAyiku/laravel-mnotify/issues)
[![GitHub stars](https://img.shields.io/github/stars/SanakeyAugustineAyiku/laravel-mnotify)](https://github.com/SanakeyAugustineAyiku/laravel-mnotify/stargazers)
[![GitHub license](https://img.shields.io/github/license/SanakeyAugustineAyiku/laravel-mnotify)](https://github.com/SanakeyAugustineAyiku/laravel-mnotify/blob/main/LICENSE)

## Send Laravel Notifications via the Mnotify SMS API

## Installation 

You can install the package via composer:

``` bash
composer require sanakey/laravel-mnotify
```

First you must install the service provider (skip for Laravel>=5.5):

``` php
// config/app.php
'providers' => [
    ...
    Sanakey\\Mnotify\\MnotifyServiceProvider::class,
],
```

In order to let your Notification know which phone number you are targeting, add the routeNotificationForMnotify method to your Notifiable model.

``` php

class User extends Model
{
     public function routeNotificationForMnotify()
    {
        return $this->contact;  // returns a contact number eg 0301045697
    }
}
```


You can publish the config file with:

```bash
php artisan vendor:publish --tag=mnotify-config
```
or
```bash
php artisan vendor:publish --provider="Sanakey\Mnotify\MnotifyServiceProvider" --tag="mnotify-config"
```

Add your mnotify api key
```
Set your mnotify api keys  .env file
MNOTIFY_SMS_API_KEY=your mnotify SMS API key

MNOTIFY_APIV2_KEY=your mnotify API V2 key
```
Add your Mnotify SMS API Key and API V2 Key to your `config/mnotify.php`:

```php
// config/services.php
...
'sms_api_key' => env('MNOTIFY_SMS_API_KEY'),
'api_v2_key' => env('MNOTIFY_APIV2_KEY'),
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification as well as send an sms notification using the mnotify api:

``` php
use Illuminate\Notifications\Notification;
use Sanakey\Mnotify\Message;


class SMSNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mnotify'];
    }

    public function toMnotify($notifiable)
    {
        return (new Message)
            ->sender_id('Sender ID')
            ->title('Approved')
            ->message('Your account was approved!');
    }
}
```


### Check balance

To check your sms balance use the `checkBalance()` method on SMSAPI object:

``` php
use Sanakey\Mnotify\SMSAPI;

$api = new SMSAPI();
$balance =$api->checkBalance();
```


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
