<?php

namespace Weew\HttpClient;

class HttpClientOptions implements IHttpClientOptions {
    /**
     * Client should follow redirects.
     */
    const FOLLOW_REDIRECT = 'follow_redirect';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param $option
     * @param null $default
     *
     * @return mixed
     */
    public function get($option, $default = null) {
        return array_get($this->options, $option, $default);
    }

    /**
     * @param $option
     * @param $value
     */
    public function set($option, $value) {
        $this->options[$option] = $value;
    }

    /**
     * @return array
     */
    public function getAll() {
        return $this->options;
    }

    /**
     * @param array|IHttpClientOptions $options
     */
    public function merge($options) {
        if ($options instanceof IHttpClientOptions) {
            $options = $options->getAll();
        }

        $this->options = array_merge($this->options, $options);
    }

    /**
     * @param $key
     */
    public function remove($key) {
        array_remove($this->options, $key);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key) {
        return array_has($this->options, $key);
    }
}
