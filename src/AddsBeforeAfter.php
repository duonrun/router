<?php

declare(strict_types=1);

namespace Duon\Router;

trait AddsBeforeAfter
{
	/** @var list<Before> */
	protected array $beforeHandlers = [];

	/** @var list<After> */
	protected array $afterHandlers = [];

	/** @psalm-api */
	public function before(Before $beforeHandler): static
	{
		$this->beforeHandlers = $this->mergeBeforeHandlers([$beforeHandler]);

		return $this;
	}

	/** @return list<Before> */
	public function beforeHandlers(): array
	{
		return $this->beforeHandlers;
	}

	/**
	 * @psalm-param list<Before> $beforeHandlers
	 * @return list<Before>
	 */
	public function mergeBeforeHandlers(array $beforeHandlers): array
	{
		return $this->mergeHandlers($this->beforeHandlers, $beforeHandlers);
	}

	/** @psalm-param list<Before> $beforeHandlers */
	public function setBeforeHandlers(array $beforeHandlers): static
	{
		$this->beforeHandlers = $beforeHandlers;

		return $this;
	}

	/** @psalm-api */
	public function after(After $afterHandler): static
	{
		$this->afterHandlers = $this->mergeAfterHandlers([$afterHandler]);

		return $this;
	}

	/** @return list<After> */
	public function afterHandlers(): array
	{
		return $this->afterHandlers;
	}

	/**
	 * @param list<After> $afterHandlers
	 * @return list<After>
	 */
	public function mergeAfterHandlers(array $afterHandlers): array
	{
		return $this->mergeHandlers($this->afterHandlers, $afterHandlers);
	}

	/** @psalm-param list<After> $afterHandlers */
	public function setAfterHandlers(array $afterHandlers): static
	{
		$this->afterHandlers = $afterHandlers;

		return $this;
	}

	/**
	 * @template T of Before|After
	 * @param list<T> $handlers
	 * @param list<T> $newHandlers
	 * @return list<T>
	 */
	protected function mergeHandlers(array $handlers, array $newHandlers): array
	{
		foreach ($newHandlers as $handler) {
			$replaced = false;
			$result = [];

			foreach ($handlers as $h) {
				if (!$replaced && $h->replace($handler)) {
					$replaced = true;
					$result[] = $handler;
				} else {
					$result[] = $h;
				}
			}

			$handlers = $result;

			if (!$replaced) {
				$handlers[] = $handler;
			}
		}

		return $handlers;
	}
}
