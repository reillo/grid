<?php namespace Reillo\Grid\Helpers;

use Illuminate\Support\Facades\Config;

class Utils {

    const CONFIG_PREFIX = 'grid::';

    /**
     * Get grid config
     *
     * @param string $grid_config
     * @return mixed
     */
    public static function config($grid_config)
    {
        return Config::get(self::CONFIG_PREFIX.$grid_config);
    }
}
