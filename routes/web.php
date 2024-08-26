<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use App\Services\PlatziService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        (new PlatziService())->retrieveProducts();

        $products = Product::with('category')->paginate(10);

        return view('dashboard')->with([
            'products' => $products,
        ]);
    })->name('dashboard');

    Route::prefix('chart')->group(function () {
        Route::get('/', [ChartController::class, 'view'])->name('chart.view');
        Route::get('/push/{id}', [ChartController::class, 'push'])->name('chart.push');
        Route::post('/remove/{id}', [ChartController::class, 'remove'])->name('chart.remove');
    });

    Route::prefix('purchases')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('purchase.list');
        Route::post('/', [PurchaseController::class, 'create'])->name('purchase.create');
    });
});

require __DIR__ . '/auth.php';
