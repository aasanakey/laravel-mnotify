<?php
namespace Tests;

use Orchestra\Testbench\TestCase;
use Sanakey\Mnotify\SMSAPI;

class SMSAPITest extends TestCase
{
    protected function setUp():void
    {
        parent::setUp();
    }

     /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
       
        $app['config']->set('mnotify.sms_api_key', env('MNOTIFY_SMS_API_KEY'));
    }

    /** @test */
    public function it_can_check_balance()
    {
        $api = new SMSAPI();
        $result = $api->checkBalance();
        $this->assertStringMatchesFormat('%d', $result);
    }

    /** @test */
    public function it_can_check_usage()
    {
        $api = new SMSAPI();
        $result = $api->checkUsage(\date_create("10-12-2020 00:00"),\date_create("26-12-2020 11:59"));
        $this->assertContains($result->code,["1000","1002","1003","1004","1005","1006","1007","1008","1009","1010", "1011","1012"]);
    }
}