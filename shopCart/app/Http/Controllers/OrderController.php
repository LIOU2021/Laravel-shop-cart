<?php

namespace App\Http\Controllers;

use App\Mail\CancelOrderMail;
use App\Mail\CreateOrderMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order $order)
    {
        return $order->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'date' => 'required|date',
            'user_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required|integer',
        ]);

        $order =  Order::create($request->all());
        
        Mail::to(Auth::user()->email)->send(new CreateOrderMail($order));

        Redis::publish('createOrder', json_encode([
            'orderId' => $order->id,
        ]));
    }

    public function showFromUser($user_id)
    {
        // ref https://laravel.com/docs/8.x/queries
        
        $users = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'products.name', 'products.price', 'products.imgUrl')
            ->get();

        return $users;
        // return Order::where('user_id', $user_id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Order::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::destroy($id);
        Mail::to(Auth::user()->email)->send(new CancelOrderMail($id));
    }
}
