<?php

namespace Tests\Weew\HttpClient;

use PHPUnit_Framework_TestCase;
use Weew\HttpClient\HttpClientOptions;

class HttpClientOptionsTest extends PHPUnit_Framework_TestCase {
    public function test_getters_and_setters() {
        $options = new HttpClientOptions();
        $this->assertEquals('foo', $options->get('foo', 'foo'));
        $options->set('foo', 'bar');
        $this->assertEquals('bar', $options->get('foo'));
    }

    public function test_merge_options() {
        $options = new HttpClientOptions();
        $this->assertEquals([], $options->toArray());

        $options->merge(['foo' => 'bar', 'bar' => 'foo']);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $options->toArray());

        $newOptions = new HttpClientOptions();
        $options->set('foobar', 'barfoo');
        $options->merge($newOptions);
        $this->assertTrue($options->has('foobar'));
        $this->assertEquals('barfoo', $options->get('foobar'));
    }

    public function test_has_option() {
        $options = new HttpClientOptions();

        $this->assertFalse($options->has('foo'));
        $options->set('foo', 'bar');
        $this->assertTrue($options->has('foo'));
    }

    public function test_remove_option() {
        $options = new HttpClientOptions();
        $options->set('foo', 'bar');
        $this->assertTrue($options->has('foo'));
        $options->remove('foo');
        $this->assertFalse($options->has('foo'));
    }
}
