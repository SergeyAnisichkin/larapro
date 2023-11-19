<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class AbstractUnitTestCase extends TestCase
{
    use CreatesApplication;
    use WithFaker;
}
