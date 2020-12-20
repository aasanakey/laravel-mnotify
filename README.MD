# Laravel Mnotify Sms Api

## Send Laravel Notifications via the Mnotify SMS API

## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/mnotify
```

First you must install the service provider (skip for Laravel>=5.5):

``` php
// config/app.php
'providers' => [
    ...
    Sanakey\\Mnotify\\MnotifyServiceProvider::class,
],
```

In order to let your Notification know which phone numer you are targeting, add the routeNotificationForMnotify method to your Notifiable model.

``` php

class User extends Model
{
     public function routeNotificationForMnotify()
    {
        return $this->contact;
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
Set your mnotify api keys  .env file
MNOTIFY_SMS_API_KEY
MNOTIFY_APIV2_KEY
Add your Mnotify SMS API Key and API V2 Key to your `config/mnotify.php`:

```php
// config/services.php
...
'sms_api_key' => env('MNOTIFY_SMS_API_KEY'),
'api_v2_key' => env('MNOTIFY_APIV2_KEY'),
...

## Usage

Now you can use the channel in your `via()` method inside the notification as well as send an sms notification using the mnotify api:

``` php
use Illuminate\Notifications\Notification;
use Sanakey\Mnotify\Message;
// use NotificationChannels\WebPush\WebPushChannel;

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

### Delete Subscriptions

To delete a subscription use the `deletePushSubscription($endpoint)` method on your user:

``` php
$user = \App\User::find(1);

$user->deletePushSubscription($endpoint);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email sa@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Cretu Eusebiu](https://github.com/cretueusebiu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.