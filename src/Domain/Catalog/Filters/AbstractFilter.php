<?php

namespace Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;
use Stringable;

abstract class AbstractFilter implements Stringable
{
    public readonly string $group;

    public function __invoke(Builder $query, $next)
    {
        return $next($this->apply($query));
    }

    public function __construct(string $group = 'filters')
    {
        $this->group = $group;
    }

    abstract public function title(): string;
    abstract public function key(): string;
    abstract public function apply(Builder $query): Builder;
    abstract public function values(): array;
    abstract public function view(): string;

    public function request(string $index = null, mixed $default = null): mixed
    {
        return request($this->group . "." . $this->key() . ($index ? ".$index" : ''), $default);
    }

    public function name(string $index = null): string
    {
        return (string) str($this->key())
            ->wrap('[', ']')
            ->prepend($this->group)
            ->when($index, fn($str) => $str->append("[$index]"));
    }

    public function id(string $index = null): string
    {
        return (string) str($this->name($index))->slug('_');
    }

    public function __toString(): string
    {
        return view($this->view(), [
            'filter' => $this
        ])->render();
    }
}
