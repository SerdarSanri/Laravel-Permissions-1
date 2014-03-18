Laravel Permissions
=====================

> A Laravel permissions bundle that uses keys rather than roles

*NOTE: If you require and/or feel like roles may be better for you, I suggest you check out [Zizaco/Entrust](https://github.com/Zizaco/Entrust)*
	
### Composer setup

In the `require` key of `composer.json` file add the following

    "connorvg/laravel-permission": "dev-master"

Run the Composer update comand

    $ composer update

### Laravel

If you're using laravel, add this service provider:
```php
'ConnorVG\Permissions\PermissionsServiceProvider'
```

Also, this Facade:
```php
'Permissions' => 'ConnorVG\Permissions\PermissionsFacade'
```