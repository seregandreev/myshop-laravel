<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryOrderController extends Controller
{
    public function index ()
    {
        if (!Auth::user()) {
            return redirect()->route('home');
        } else {
            $user = Auth::user();
            $orders = Order::where('user_id', $user->id)->get();
            return view('history.index', compact('orders'));
        }

    }

    public function replayToCart ()
    {
        $orderId = request('orderId');
        //dd(session()->all());
        $cart = session('cart') ?? [];

        $order = Order::where('id', $orderId)->first();
        $products = $order->products()->get();
        /*dd($products);
         foreach ($products as $product){
            session(
                [
                    $cart[$product->id] => $product->pivot->quantity
                ]);
        }

        session()->put('cart', $cart);*/
        return back();
    }
}
