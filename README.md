## Laravel 4 Simple Grid

### Installation

Add the following to your `composer.json` file:

```json
"reillo/grid": "dev-master"
```

Then, run `composer update reillo/grid` or `composer install` if you have not already installed packages.

Publish asset:

```
php artisan asset:publish reillo/grid
```

Publish view:

```
php artisan view:publish reillo/grid
```

Publish config:

```
php artisan config:publish reillo/grid
```

### features
 - uses laravel paginator
 - support table and list renderer
 - html5 push history
 - ajax request
 - removable filters

### Usage
see [example](https://github.com/reillo/grid/tree/master/src/Example).

### Todo
Documentations

## License
This project is open-sourced software licensed under the [MIT license][mit-url].

[mit-url]: http://opensource.org/licenses/MIT

