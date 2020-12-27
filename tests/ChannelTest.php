<?php
namespace Tests;

use Orchestra\Testbench\TestCase;
use Tests\Notifications\ExampleNotification;
use Tests\Models\User;
use Sanakey\Mnotify\MnotifyChannel;

class ChannelTest extends TestCase{

    
    protected function setUp():void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/migrations'),
        ])->run();

    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('mnotify.sms_api_key', env('MNOTIFY_SMS_API_KEY'));
    }

    protected function getPackageProviders($app)
    {
        return ['Sanakey\Mnotify\MnotifyServiceProvider'];
    }

    /** @test */
    public function it_sends_sms()
    {
        $success = '{"code":"1000","message":"Message submitted successful"}';
        $user = User::create([
            "name"=> "Test user",
            "phone"=> "233549248795",
        ]);
        $notification = new ExampleNotification();
        $response = (new MnotifyChannel())->send($user,$notification);
        $this->assertContains($response->code,["1000","1002","1003","1004","1005","1006","1007","1008","1009","1010", "1011","1012"]);
    }
    
}