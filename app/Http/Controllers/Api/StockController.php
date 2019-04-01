<?php

namespace App\Http\Controllers\Api;

use App\Stocks;
use App\Http\Resources\StockResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class StockController extends Controller
{
    public function all()
    {
        return StockResource::collection(Stocks::all());
    }
    public function show(Stocks $stock)
    {
        return new StockResource($stock);
    }
    public function update(Stocks $stock, Request $request)
    {
        $data = $request->validate([
            'name'    => '',
            'mire_id' => '',
            'count'   => '',
            'limit'   => '',
            'email'   => ''
        ]);

        $stock->update($data);

        return new StockResource($stock);
    }
    public function destroy(Stocks $stock)
    {
        $stock->delete();

        return response(null, 204);
    }
    public function create(Stocks $stock, Request $request)
    {
            $data = $request->validate([
                'name'    => '',
                'mire_id' => '',
                'count'   => '',
                'limit'   => '',
                'email'   => ''
        ]);

        $stock->create($data);

        return new StockResource($stock);
    }
    public function updateAll(Request $request)
    {
        return response('Update success', 200);
    }
    public function check()
    {
        $items = Stocks::all();
        foreach($items as $item){
            if($item->limit > $item->count){
                Mail::send([], ['item' => $item], function ($message) use ($item) {
                    $message->from('WoofLuck@crm.app', 'admin');
                    $message->to($item->email, $item->email)
                    ->subject('Кiлькiсть матерiалу на складi')
                    ->setBody('Звернiть свою увагу. '.$item->name.' залишилось на складi '.$item->count.' '.$item->mire_id);
                });
            }

        }
    }

}
