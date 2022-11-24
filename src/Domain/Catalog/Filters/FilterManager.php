<?php

namespace Domain\Catalog\Filters;

final class FilterManager
{
    public function __construct(
        protected array $filters = []
    ) {}

    public function registerFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }
}
