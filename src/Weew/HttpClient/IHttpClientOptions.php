<?php

namespace Weew\HttpClient;

interface IHttpClientOptions {
    /**
     * @return array
     */
    function getAll();

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
