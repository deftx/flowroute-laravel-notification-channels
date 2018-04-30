# Flowroute Laravel notifications channel for Laravel 5.4+


This package makes it easy to send SMS notifications using [Flowroute](https://flowroute.com) with Laravel 5.4+

## Contents

- [Installation](#installation)
	- [Setting up the Flowroute service](#setting-up-the-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:
`composer require deftx/flowroute-laravel-notification-channels`

Add the service provider to `config/app.php`:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Flowroute\FlowrouteServiceProvider::class,
],
```

### Setting up the service
Log in to your [Flowroute account](https://manage.flowroute.com/accounts/preferences/api/) and set your API credentials. Add them to `config/services.php`.  

```php
// config/services.php
...
'flowroute' => [
    'access_key' => env('SMS_ACCESS_KEY'),
    'secret_key' => env('SMS_SECRET_KEY'),
    'from_number' => env('SMS_FROM', '1800XXXXXXX'),
    'send_to_override' => env('SMS_DEV', false),
    'forward_to' => env('SMS_DEV', '1XXXXXXXXXX'),
    'webhook_url' => env('APP_URL') . '/webhooks/sms/receive',
],
```

## Usage

Follow Laravel's documentation to add the channel your Notification class:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Flowroute\FlowrouteChannel;
use NotificationChannels\Flowroute\FlowrouteMessage;

public function via($notifiable)
{
    return [FlowrouteChannel::class];
}

public function toFlowroute($notifiable)
{
    return (new FlowrouteMessage)
                    ->content('This is a test SMS via Flowroute using Laravel Notifications!');
}
```  

Add a `routeNotificationForFlowroute` method to your Notifiable model to return the phone number:  

```php
public function routeNotificationForFlowroute()
{
    // Country code, area code and number without symbols or spaces
    return preg_replace('/\D+/', '', $this->phone_number);
}
```    

### Available methods

* `content()` - (string), SMS notification body
* `from()` - (integer) Override default from number

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Rob Vella](https://github.com/deftx)
- [Sid K - original creator of Plivo channel](https://github.com/koomai)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
