<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis;


class RedisTest extends TestCase
{
    public function testCanRedisGetAndSetValue()
    {
        Redis::set('key', 'value');
        $this->assertEquals('value', Redis::get('key'));
    }

    public function testCanRedisStoreMultipleValues()
    {
        Redis::hmset('hash', ['field1' => 'value1', 'field2' => 'value2']);

        $this->assertEquals('value1', Redis::hget('hash', 'field1'));
        $this->assertEquals('value2', Redis::hget('hash', 'field2'));
    }

}
