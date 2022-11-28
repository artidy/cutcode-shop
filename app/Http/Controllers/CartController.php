<?php

namespace App\Http\Controllers;

use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function index(): Application|Factory|View
    {
        return view('cart.index', [
            'items' => cart()->cartItems()
        ]);
    }

    public function add(Product $product): RedirectResponse
    {
        cart()->add(
            $product,
            request('quantity', 1),
            request('options', [])
        );

        flash()->info('Товар добавлен в корзину');

        return redirect()->intended(route('cart'));
    }

    public function quantity(CartItem $cartItem): RedirectResponse
    {
        cart()->quantity($cartItem, request('quantity', 1));

        flash()->info('Количество товаров изменено');

        return redirect()->intended(route('cart'));
    }

    public function delete(CartItem $cartItem): RedirectResponse
    {
        cart()->delete($cartItem);

        flash()->info('Удалено из корзины');

        return redirect()->intended(route('cart'));
    }

    public function truncate(): RedirectResponse
    {
        cart()->truncate();

        flash()->info('Корзина очищена');

        return redirect()->intended(route('cart'));
    }
}
