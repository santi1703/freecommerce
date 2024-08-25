<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChartController extends Controller
{
    public function push(int $id)
    {
        $chart = Session::get('chart');

        if (empty($chart)) {
            $products = [];
        } else {
            $products = $chart;
        }

        $products[$id] = (empty($products[$id]) ? 0 : $products[$id]) + 1;

        Session::put(['chart' => $products]);
        Session::flash('message', __('app.chart.product_added'));

        return redirect()->route('dashboard');
    }

    public function remove(int $id)
    {
        $chart = Session::get('chart');

        unset($chart[$id]);

        Session::put(['chart' => $chart]);

        Session::flash('message', __('app.chart.product_removed'));
        return redirect()->back();
    }

    public function view()
    {
        $chart = Session::get('chart');
        $products = collect();
        $total = null;

        if (!empty($chart)) {
            $products = Product::whereIn('id', array_keys($chart))->get();

            $products->map(function ($product) use ($chart) {
                return $product->quantity = $chart[$product->id];
            });

            $total = $products->reduce(function (?int $carry, Product $product) {
                return $carry + ($product->quantity * $product->price);
            });
        }

        return view('chart')->with([
            'products' => $products,
            'total' => $total,
        ]);
    }
}
