<?php namespace Csgt\Hermes;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class HermesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('csgt/hermes');
		AliasLoader::getInstance()->alias('Hermes','Csgt\Hermes\Hermes');
	}

	public function register() {
		$this->app['hermes'] = $this->app->share(function($app) {
    	return new Hermes;
  	});
	}

	public function provides() {
		return array('hermes');
	}

}
