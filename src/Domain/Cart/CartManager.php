<?php

namespace Domain\Cart;

use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

class CartManager
{
    public function __construct(
        protected CartIdentityStorageContract $identityStorage
    ) {}

    private function cacheKey(): string
    {
        return str('cart_' . $this->identityStorage->get())
            ->slug('_')
            ->value();
    }

    private function resetCache(): void
    {
        Cache::forget($this->cacheKey());
    }

    private function storageData(string $storage_id): array
    {
        $data = [
            'storage_id' => $storage_id
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    private function formatOptionValues(array $optionValues): string
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = []): Model|Builder
    {
        $storageId = $this->identityStorage->get();
        $productKey = $product->getKey();
        $stringOptionValues = $this->formatOptionValues($optionValues);

        $cart = Cart::query()->updateOrCreate([
                'storage_id' => $storageId
            ], $this->storageData($storageId));

        $cartItem = $cart->cartItems()->updateOrCreate([
            'product_id' => $productKey,
            'string_option_values' => $stringOptionValues
        ], [
            'product_id' => $productKey,
            'quantity' => DB::raw("quantity + $quantity"),
            'price' => $product->price->raw(),
            'string_option_values' => $stringOptionValues
        ]);

        $cartItem->optionValues()->sync($optionValues);

        $this->resetCache();

        return $cart;
    }

    public function quantity(CartItem $cartItem, int $quantity): void
    {
        $cartItem->update(['quantity' => $quantity]);

        $this->resetCache();
    }

    public function delete(CartItem $cartItem): void
    {
        $cartItem->delete();

        $this->resetCache();
    }

    public function truncate(): void
    {
        $this->get()?->delete();

        $this->resetCache();
    }

    public function get(): Cart|false
    {
        return Cache::remember($this->cacheKey(), now()->addHour(), function () {
            return Cart::query()
                ->with('cartItems')
                ->where('storage_id', $this->identityStorage->get())
                ->when(auth()->check(), fn(Builder $query) => $query->orWhere(['user_id' => auth()->id()]))
                ->first() ?? false;
        });
    }

    public function items(): Collection
    {
        if (!$this->get()) {
            return collect([]);
        }

        return CartItem::query()
            ->with(['product', 'optionValues.option'])
            ->whereBelongsTo($this->get())
            ->get();
    }

    public function cartItems(): Collection
    {
        return $this->get()?->cartItems ?? collect([]);
    }

    public function count(): int
    {
        return $this->cartItems()->sum(fn ($item) => $item->quantity);
    }

    public function amount(): Price
    {
        return Price::make($this->cartItems()->sum(fn ($item) => $item->amount->raw()));
    }

    public function updateStorageKey(string $previousKey, string $currentKey): void
    {
        Cart::query()
            ->where(['storage_id' => $previousKey])
            ->update($this->storageData($currentKey));
    }
}
