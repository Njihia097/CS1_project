<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add_cart(Request $request, $id)
    {

        if(Auth::id())
        {

            $user=Auth::user();
            
            $artist= artist::find($id);

            $cart=new cart;

            $cart->name=$user->name;
            $cart->email=$user->email;
            $cart->phone=$user->phone;
            $cart->user_id=$user->id;

            $cart->art_title=$artist->title;
            $cart->price=$artist->price;
            $cart->image=$artist->image_path;
            $cart->art_id=$artist->id;
            $cart->quantity=1;

            $cart->save();

            return redirect()->back();


        }

        else{
            return redirect('login');
        }
    }

    public function show_cart()
    {
        if(Auth::id())
        {
        $id=Auth::user()->id;

        $cart=cart::where('user_id', '=',$id)->get();
        return view('home.shopcart', compact('cart'));
    }else{
        return redirect('login');
    }
}

public function remove_cart($id)
{
    $cart=cart::find($id);
    $cart->delete();

    return redirect()->back();
}

public function cash_order()
{

    $user=Auth::user();
    $userid=$user->id;

    $data=cart::where('user_id', '=', $userid)->get();

    foreach($data as $item)
    {
        $order=new order;

        $order->name=$item->name;
        $order->email=$item->email;
        $order->phone=$item->phone;
        $order->user_id=$item->user_id;
        $order->art_title=$item->art_title;
        $order->price=$item->price;
        $order->quantity=$item->quantity;
        $order->image=$item->image;
        $order->art_id=$item->art_id;

        $order->payment_status='cash on delivery';
        $order->delivery_status='processing';
        $order->save();

        $cart_id=$data->id;
        $cart=cart::find($cart_id);
        $cart->delete();



    }

    return redirect()->back()->with('message','Order received and is being processed');

}

public function show_order()
{
    if(Auth::id())
    {
    $id=Auth::user()->id;

    $order=order::where('user_id', '=',$id)->get();
    return view('home.order', compact('order'));
}else{
    return redirect('login');
}
}

}
