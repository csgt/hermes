<?php namespace Csgt\Hermes;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class HermesServiceProvider extends ServiceProvider {

	protected $defer = false;

	public function boot(Router $router) {
		$this->mergeConfigFrom(__DIR__ . '/config/csgthermes.php', 'csgthermes');
		$this->loadViewsFrom(__DIR__ . '/resources/views/','csgthermes');

		AliasLoader::getInstance()->alias('Hermes','Csgt\Hermes\Hermes');

		$this->publishes([
      __DIR__.'/config/csgthermes.php' => config_path('csgthermes.php'),
    ], 'config');
	}

	public function register() {
		$this->app['hermes'] = $this->app->share(function($app) {
    	return new Hermes;
  	});
	}

	public function provides() {
		return ['hermes'];
	}
}