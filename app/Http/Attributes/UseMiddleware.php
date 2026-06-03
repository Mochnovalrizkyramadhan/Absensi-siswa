<?php

namespace App\Http\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class UseMiddleware
{
    public function __construct(
        public readonly string $middleware,
    ) {
    }
}
