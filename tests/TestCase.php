<?php

namespace Tests;

use Symfony\Component\HttpFoundation\Response as Response;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected const HTTP = Response::class;
}
