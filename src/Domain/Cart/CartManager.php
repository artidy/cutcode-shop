<?php

namespace Domain\Cart;

use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

class CartManager
{
    public function __construct(
        protected CartIdentityStorageContract $identityStorage
    ) {}

    private function storageData(string $storage_id)
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
        $storage_id = $this->identityStorage->get();
        $product_key = $product->getKey();
        $string_option_values = $this->formatOptionValues($optionValues);

        $cart = Cart::query()->updateOrCreate([
                'storage_id' => $storage_id
            ], $this->storageData($storage_id));

        $cartItem = $cart->updateOrCreate([
            'product_id' => $product_key,
            'string_option_values' => $string_option_values
        ], [
            'product_id' => $product_key,
            'quantity' => DB::raw("quantity + $quantity"),
            'string_option_values' => $string_option_values
        ]);

        $cartItem->optionValues()->sync($optionValues);

        return $cart;
    }

    public function quantity(CartItem $cartItem, int $quantity): void
    {
        $cartItem->update(['quantity' => $quantity]);
    }

    public function delete(CartItem $cartItem): void
    {
        $cartItem->delete();
    }

    public function truncate(): void
    {
        $this->get()?->delete();
    }

    public function get(): Cart
    {
        return Cart::query()
            ->with('cartItems')
            ->where('storage_id', $this->identityStorage->get())
            ->when(auth()->check(), fn(Builder $query) => $query->orWhere(['user_id' => auth()->id()]))
            ->first();
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
}
