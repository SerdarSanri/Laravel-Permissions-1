<?php namespace ConnorVG\Permissions;

use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('connorvg/permissions', null, __DIR__.'/../../..');

		include __DIR__.'/../../filters.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerPermissions(); 

		$this->registerCommands();
	}

	/**
	 * Register the application bindings.
	 *
	 * @return void
	 */
	protected function registerPermissions()
	{
		$this->app->bind('permissions', function($app)
		{
			return new Permissions($app);
		});
	}

	/**
	 * Register the artisan commands.
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
		$this->app['command.permissions.migration'] = $this->app->share(function($app)
		{
			return new MigrationCommand($app);
		});

		$this->commands(
			'command.permissions.migration'
		);
	}
}