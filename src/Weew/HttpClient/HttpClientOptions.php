<?php

namespace Weew\HttpClient;

class HttpClientOptions implements IHttpClientOptions {
    /**
     * Client should follow redirects.
     */
    const FOLLOW_REDIRECT = 'follow_redirect';

    /**
     * Client should verify the SSL certificates.
     */
    const VERIFY_SSL = 'verify_ssl';

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
     * @param array|IHttpClientOptions $options
     */
    public function merge($options) {
        if ($options instanceof IHttpClientOptions) {
            $options = $options->toArray();
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

    /**
     * @return array
     */
    public function toArray() {
        return $this->options;
    }
}
