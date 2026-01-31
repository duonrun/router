<?php

declare(strict_types=1);

namespace Duon\Router\Tests\Fixtures;

use Attribute;
use Duon\Wire\Call;

#[Attribute]
#[Call('init')]
class TestCallableAttribute
{
	public bool $initialized = false;

	public function init(): void
	{
		$this->initialized = true;
	}
}
