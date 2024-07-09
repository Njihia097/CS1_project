<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;

class CartController extends Controller
{
    public function add_cart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $artist = Artist::findOrFail($id);

            $cart[$id] = [
                "title" => $artist->title,
                "width" => $artist->width,
                "height" => $artist->height,
                "price" => $artist->price,
                "quantity" => 1,
                "image" => $artist->image_path,  // Use image_path
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart successfully');
    }

    public function show_cart()
    {
        $cartItems = session()->get('cart', []);
        return view('home.cart', compact('cartItems'));
    }

    public function remove_item($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart successfully');
    }

    public function update_cart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        foreach ($request->items as $id => $data) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $data['quantity'] ?? 1; // Default to 1 if quantity is not set
            }
        }
        
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Cart updated successfully');
    }
}
