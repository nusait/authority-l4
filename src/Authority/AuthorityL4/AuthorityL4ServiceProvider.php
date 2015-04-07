<?php
namespace Authority\AuthorityL4;

use Authority\Authority;
use Illuminate\Support\ServiceProvider;

class AuthorityL4ServiceProvider extends ServiceProvider
{
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(){
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('authority.php'),
        ]);

        $this->app['authority'] = $this->app->share(function($app){
            $user = $app['auth']->user();
            $authority = new Authority($user);
            $fn = $app['config']->get('authority::initialize', null);

            if($fn) {
                $fn($authority);
            }

            return $authority;
        });
        
        $this->app->alias('authority', 'Authority\Authority');
    }

}
