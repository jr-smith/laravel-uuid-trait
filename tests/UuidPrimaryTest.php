<?php

namespace JrSmith\Uuid\Tests;

use Illuminate\Database\Eloquent\Model;
use JrSmith\Uuid\UuidPrimary;
use ReflectionMethod;

class UuidPrimaryTest extends TestCase
{
    /** @test */
    public function it_will_set_uuid()
    {
        $class = new class extends Model
        {
            use UuidPrimary;
        };

        $this->assertNull($class->getAttribute('id'));

        $method = new ReflectionMethod($class, 'fireModelEvent');
        $method->setAccessible(true);
        $method->invoke($class, 'saving');

        $this->assertNotEmpty($class->getAttribute('id'));
    }
}
