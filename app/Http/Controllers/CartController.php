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
        return view('cart.index');
    }

    public function add(Product $product): RedirectResponse
    {
        flash()->info('Товар добавлен в корзину');

        return redirect()->intended(route('cart'));
    }

    public function quantity(CartItem $cartItem): RedirectResponse
    {
        flash()->info('Количество товаров изменено');

        return redirect()->intended(route('cart'));
    }

    public function delete(CartItem $cartItem): RedirectResponse
    {
        flash()->info('Удалено из корзины');

        return redirect()->intended(route('cart'));
    }

    public function truncate(): RedirectResponse
    {
        flash()->info('Корзина очищена');

        return redirect()->intended(route('cart'));
    }
}
