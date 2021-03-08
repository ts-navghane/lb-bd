<?php

declare(strict_types=1);

namespace App\Tests;

use App\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testApplicationInstanceIsReturned()
    {
        $app = new Application;

        self::assertInstanceOf(Application::class, $app);
    }
}
