<?php

namespace Weew\HttpClient;

use Weew\Contracts\IArrayable;

interface IHttpClientOptions extends IArrayable {
    /**
     * @param $option
     *
     * @param null $default
     *
     * @return mixed
     */
    function get($option, $default = null);

    /**
     * @param $option
     * @param $value
     */
    function set($option, $value);

    /**
     * @param $option
     */
    function remove($option);

    /**
     * @param $option
     *
     * @return bool
     */
    function has($option);

    /**
     * @param array|IHttpClientOptions $options
     */
    function merge($options);
}
