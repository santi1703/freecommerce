<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = (Auth::user())->purchases()->with('products')->get();

        return view('purchases')->with([
            'purchases' => $purchases,
        ]);
    }

    public function create()
    {
        $chart = Session::get('chart');
        $products = Product::whereIn('id', array_keys($chart))->get();
        $products->map(function ($product) use ($chart) {
            return $product->quantity = $chart[$product->id];
        });
        $total = $products->reduce(function (?int $carry, Product $product) {
            return $carry + ($product->quantity * $product->price);
        });

        $user = Auth::user();

        if ($user->account < $total) {
            Session::flash('message', __('app.credits.insufficient'));
            return redirect()->route('dashboard');
        }

        try {
            $purchase = Purchase::create([
                'user_id' => Auth::user()->id,
                'total' => $total,
            ]);

            foreach ($products as $product) {
                DB::table('product_purchase')
                    ->insert([
                        'product_id' => $product->id,
                        'purchase_id' => $purchase->id,
                        'quantity' => $product->quantity,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }

            $user->update(['account' => $user->account - $total]);

            Session::forget('chart');
            Session::save();

            Session::flash('message', __('app.purchase.successful'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('dashboard');
    }
}
