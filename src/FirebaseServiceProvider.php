<?php

namespace Alfa6661\Firebase;

use Exception;
use Illuminate\Support\ServiceProvider;
use paragraph1\phpFCM\Client;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(FirebaseChannel::class)
            ->needs(Client::class)
            ->give(function () {
                $firebaseConfig = config('services.firebase');
                if (is_null($firebaseConfig)) {
                    throw new Exception('In order to send notification via firebase you need to add credentials in the `firebase` key of `config.services`.');
                }
                $client = new Client();
                $client->setApiKey($firebaseConfig['api_key']);
                $client->injectHttpClient(new \GuzzleHttp\Client());

                return $client;
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
