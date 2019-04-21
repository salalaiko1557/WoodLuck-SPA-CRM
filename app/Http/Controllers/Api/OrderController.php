<?php

namespace App\Http\Controllers\Api;

use App\Orders;
use App\Http\Resources\OrderResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function all()
    {
        $all_orders = OrderResource::collection(Orders::orderBy('canban_status')->get());

        $first_column_orders = OrderResource::collection(Orders::orderBy('canban_status')
                ->where('canban_column', '=', 1)
                ->get());
        $second_column_orders = OrderResource::collection(Orders::orderBy('canban_status')
                ->where('canban_column', '=', 2)
                ->get());
        $third_column_orders = OrderResource::collection(Orders::orderBy('canban_status')
                ->where('canban_column', '=', 3)
                ->get());
        $fourth_column_orders = OrderResource::collection(Orders::orderBy('canban_status')
                ->where('canban_column', '=', 4)
                ->get());
        $fiveth_column_orders = OrderResource::collection(Orders::orderBy('canban_status')
                ->where('canban_column', '=', 5)
                ->get());
        // info(print_r($first_column_orders, true));
        //return $all_orders;
        return [
            $first_column_orders,
            $second_column_orders,
            $third_column_orders,
            $fourth_column_orders,
            $fiveth_column_orders
        ];
    }
    public function show(Orders $order)
    {
        return new OrderResource($order);
    }
    public function update(int $order_id, Request $request)
    {
        // info(['order_id' => $order_id, 'request' => $request->all()]);

        $order = Orders::find($order_id);
        $data = $request->validate([
            'customer_id'    => '',
            'order_type_id'  => '',
            'price'          => '',
            'pay_type_id'    => '',
            'description'    => '',
            'text_execution' => '',
            'date_execution' => '',
            'material_id'    => '',
            'material_count' => '',
            'canban_status'  => '',
            'canban_column'  => '',
            'draw'           => '',
            'mires_id'       => '',
            'delivery_adress'=> ''
        ]);

        if($request->file('draw')){
            $data['draw'] = $request->file('draw')->store('uploads', 'public');
         }else{

         }
        $order->update($data);

        return new OrderResource($order);
    }
    public function poebota(Request $request) {
        info($request);
    }
    public function destroy(Orders $order)
    {
        $order->delete();

        return response(null, 204);
    }
    public function create(Orders $order, Request $request)
    {
        $data = $request->validate([
            'customer_id'    => '',
            'order_type_id'  => '',
            'price'          => '',
            'pay_type_id'    => '',
            'description'    => '',
            'text_execution' => '',
            'date_execution' => '',
            'material_id'    => '',
            'material_count' => '',
            'canban_status'  => '',
            'canban_column'  => '',
            'draw'           => '',
            'mires_id'       => '',
            'delivery_adress'=> ''
        ]);
         if($request->file('draw')){
            $data['draw'] = $request->file('draw')->store('uploads', 'public');
         }else{
            $data['draw'] = '';
         }
         $order->create($data);

        return new OrderResource($order);
    }
    public function updateAll(Request $request)
    {

        $orders = Orders::all();
        foreach ($orders as $order){
            $id = $order->id;
            foreach($request->data as $request_order){
                if($request_order['id'] == $id){
                    $order->canban_status = $request_order['canban_status'];
                    $order->save();
                }
            }
        }

        return response('Update success', 200);
    }
    public function getDraw(Request $request){
         return response()->download(storage_path('app/public/' . $request->draw));
    }
}
