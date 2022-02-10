<?php

namespace Tests;

use App\Models\{User, Role};
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;



abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;
    
    public $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->detectEnvironment( function () {
            return 'testing';
        });

    }

    public function tearDown() : void
    {
        parent::tearDown();
    }

}
