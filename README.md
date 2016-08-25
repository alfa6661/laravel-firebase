# laravel-firebase
Google Firebase Notification for Laravel 5.2

This package makes it easy to send Firebase Notification with Laravel 5.2.

## Installation

You can install the package via composer:

``` bash
composer require alfa6661/laravel-firebase
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Alfa6661\Firebase\FirebaseServiceProvider::class,
],
```

### Setting up your Firebase account

Add your Firebase Key to your `config/services.php`:

```php
// config/services.php
...
'firebase' => [
    'api_key' => env('FIREBASE_API_KEY'),
],
...
```


## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use Alfa6661\Firebase\FirebaseChannel;
use Alfa6661\Firebase\FirebaseMessage;
use Illuminate\Notifications\Notification;

class CreditWasCreated extends Notification
{
    public function via($notifiable)
    {
        return [FirebaseChannel::class];
    }

    public function toFirebase($notifiable)
    {
        return FirebaseMessage::create()
            ->title('Title')
            ->body('Push notification body')
            ->data(['id' => $notifiable->id]);
    }
}
```

In order to let your Notification know which device user(s) you are targeting, add the `routeNotificationForFirebase` method to your Notifiable model.

You can either return a single device token, or if you want to notify multiple device just return an array containing all devices.

```php
public function routeNotificationForFirebase()
{
    return ["DEVICE_TOKEN", "DEVICE_TOKEN"];
}
```
