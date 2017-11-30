<?php

namespace Alfa6661\Firebase;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;
use paragraph1\phpFCM\Client as FcmClient;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(FirebaseChannel::class)
            ->needs(FcmClient::class)
            ->give(function () {
                $firebaseConfig = config('services.firebase');

                if (is_null($firebaseConfig)) {
                    throw new Exception('In order to send notification via firebase you need to add credentials in the `firebase` key of `config.services`.');
                }

                $client = new FcmClient();
                $client->setApiKey($firebaseConfig['api_key']);
                $client->injectHttpClient(new GuzzleClient());

                return $client;
            });
    }
}
