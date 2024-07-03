<?php

namespace Tests;

use Riobet\AccessKey\App\AccessKeyServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return jeremykenedy\LaravelBlocker\LaravelBlockerServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [AccessKeyServiceProvider::class];
    }

    /**
     * Load package alias.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'accesskey',
        ];
    }
}
