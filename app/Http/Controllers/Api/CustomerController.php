<?php

namespace App\Http\Controllers\Api;

use App\Customers;
use App\Http\Resources\CustomerResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function all()
    {
        return CustomerResource::collection(Customers::all());
    }
    public function show(Customers $customer)
    {
        return new CustomerResource($customer);
    }
    public function update(Customers $customer, Request $request)
    {
        $data = $request->validate([
            'name'             => '',
            'surname'          => '',
            'company'          => '',
            'telephone'        => '',
            'email'            => '',
            'orders_sum'       => '',
            'source_id'        => '',
            'delivery'         => '',
            'rate_value'       => '',
            'rate_description' => '',
        ]);

        $customer->update($data);

        return new CustomerResource($customer);
    }
    public function destroy(Customers $customer)
    {
        $customer->delete();

        return response(null, 204);
    }
    public function create(Customers $customer, Request $request)
    {
            $data = $request->validate([
            'name'             => '',
            'surname'          => '',
            'company'          => '',
            'telephone'        => '',
            'email'            => '',
            'orders_sum'       => '',
            'source_id'        => '',
            'delivery'         => '',
            'rate_value'       => '',
            'rate_description' => '',
        ]);

        $customer->create($data);

        return new CustomerResource($customer);
    }
    public function updateAll(Request $request)
    {
        info($request);

        return response('Update success', 200);
    }
}
