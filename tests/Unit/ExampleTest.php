<?php

namespace Tests\Unit;

use App\Common\Xpath;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testXpathTest() {
        $model = \App\Xpath::find(1);
        $titles = Xpath::analysis($model);

        info($titles);

        $this->assertEquals(10, count($titles), '获取的数据不对');
    }
}
