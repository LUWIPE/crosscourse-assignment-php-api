<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Digital;
use App\Models\Grade;
use App\Models\Product;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/database', function () {
    $error = null;

    try {
        $products = Product::with(['type', 'grade', 'digital'])->orderBy('id')->get();
        $types = Type::orderBy('id')->get();
        $grades = Grade::orderBy('id')->get();
        $digitals = Digital::orderBy('id')->get();
        $users = User::orderBy('id')->get();
        $carts = Cart::orderBy('id')->get();
        $cartItems = CartItem::orderBy('id')->get();
    } catch (\Throwable $exception) {
        $error = $exception->getMessage();
        $products = collect();
        $types = collect();
        $grades = collect();
        $digitals = collect();
        $users = collect();
        $carts = collect();
        $cartItems = collect();
    }

    return view('database', [
        'error' => $error,
        'products' => $products,
        'types' => $types,
        'grades' => $grades,
        'digitals' => $digitals,
        'users' => $users,
        'carts' => $carts,
        'cartItems' => $cartItems,
    ]);
});

