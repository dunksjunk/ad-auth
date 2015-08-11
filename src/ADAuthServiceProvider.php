<?php namespace dunksjunk\ADAuth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ADAuthServiceProvider extends ServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
      
      $this->publishes([ __DIR__ . '/config/adauth.php' => config_path('adauth.php') ], 'config');
      
      Auth::extend('ads', function() {
        return new ADAuthUserProvider();
      });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
      //
    }

}
