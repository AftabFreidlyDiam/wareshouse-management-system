<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/', App\Http\Livewire\Dashboard\Pages\IndexPage::class)
    //     ->name('dashboard.index');

    // Route::prefix('/users')->group(function() {
    //     Route::get('/', App\Http\Livewire\User\Pages\UserIndexPage::class)
    //         ->middleware('permission:user.view')
    //         ->name('user.index');
    //     Route::get('/add', App\Http\Livewire\User\Pages\UserAddPage::class)
    //         ->name('user.add')
    //         ->middleware('permission:user.create');
    //     Route::get('{id}/edit', App\Http\Livewire\User\Pages\UserEditPage::class)
    //         ->name('user.edit')
    //         ->middleware('permission:user.update');
    // });

    Route::prefix('/goods')->group(function() {
        Route::get('/', [App\Http\LivewireApi\Goods\Pages\IndexPage::class, 'list'])   // Fetch All Goods
            ->name('api.goods.index')
            ->middleware('permission:view');
        Route::post('/add', [App\Http\LivewireApi\Goods\Pages\AddGoodsPage::class,'submit'])   // Add Goods
            ->name('api.goods.add')
            ->middleware('permission:goods.create');
        Route::get('{id}/edit', [App\Http\LivewireApi\Goods\Pages\EditGoodsPage::class, 'getEdit'])  // Edit Goods
            ->name('api.goods.edit')
            ->middleware('permission:goods.update');
        Route::put('/update', [App\Http\LivewireApi\Goods\Pages\EditGoodsPage::class,'submit'])  // Update goods
        ->name('api.goods.update')
        ->middleware('permission:goods.update');
        Route::get('{id}/detail', [App\Http\LivewireApi\Goods\Pages\DetailGoodsPage::class, 'loadGoods'])  // Get goods Details
            ->name('api.goods.detail');

    });

    Route::prefix('/goods-categories')->group(function() {
        Route::get('/', [App\Http\LivewireApi\GoodsCategory\Components\GoodsCategoryTable::class, 'categoryList'])
            ->name('api.goods-category.index');
            // ->middleware('permission:view');
        Route::post('/add', [App\Http\LivewireApi\GoodsCategory\Pages\AddCategoryPage::class,'submit'])
            ->name('api.goods-category.add');
            // ->middleware('permission:goods-category.create');
        Route::get('/{id}/edit', [App\Http\LivewireApi\GoodsCategory\Pages\EditCategoryPage::class,'getEdit'])
            ->name('api.goods-category.edit');
            // ->middleware('permission:goods-category.update');
            Route::put('/update', [App\Http\LivewireApi\GoodsCategory\Pages\EditCategoryPage::class,'submit'])  // Update goods
            ->name('api.goods.update');
            // ->middleware('permission:goods.update');
    });

    Route::prefix('/suppliers')->group(function() {
        Route::get('/', [App\Http\LivewireApi\Supplier\Pages\IndexPage::class, 'supplierList'])
            ->name('supplier.index');
            // ->middleware('permission:supplier.view');
        Route::post('/add', [App\Http\LivewireApi\Supplier\Pages\AddSupplierPage::class,'submit'])
            ->name('supplier.add');
        Route::get('{id}/edit', [App\Http\LivewireApi\Supplier\Pages\EditSupplierPage::class, 'getEdit'])
            ->name('supplier.edit');
        Route::put('/update', [App\Http\LivewireApi\Supplier\Pages\EditSupplierPage::class,'submit'])
            ->name('supplier.update');
    });

    Route::prefix('/shippers')->group(function() {
        Route::get('/', [App\Http\LivewireApi\Shipper\Pages\IndexPage::class, 'shipperList'])
            ->name('api.shipper.index');
        Route::post('/add', [App\Http\LivewireApi\Shipper\Pages\AddShipperPage::class, 'submit'])
            ->name('api.shipper.add');
            // ->middleware('permission:shipper.create');
        Route::get('{id}/edit', [App\Http\LivewireApi\Shipper\Pages\EditShipperPage::class, 'getEdit'])
            ->name('api.shipper.edit');
            // ->middleware('permission:shipper.update');
        Route::put('/update', [App\Http\LivewireApi\Shipper\Pages\EditShipperPage::class,'submit'])
            ->name('api.shipper.update');
    });

    Route::prefix('/receiving')->group(function() {
        Route::get('/', [App\Http\LivewireApi\Receiving\Pages\IndexPage::class, 'getList'])
            ->name('receiving.index');
        Route::get('{id}/detail', [App\Http\LivewireApi\Receiving\Pages\DetailReceivingPage::class, 'getEdit'])
            ->name('receiving.detail');
        Route::post('/add', [App\Http\LivewireApi\Receiving\Pages\AddReceivingPage::class, 'submit'])
            ->name('receiving.add')
            ->middleware('permission:goods-transaction.create');

    });

    Route::prefix('/dispatching')->group(function() {
        Route::get('/', App\Http\Livewire\Dispatching\Pages\IndexPage::class)
            ->name('dispatching.index');
        Route::get('/add', App\Http\Livewire\Dispatching\Pages\AddDispatchingPage::class)
            ->name('dispatching.add')
            ->middleware('permission:goods-transaction.create');
        Route::get('/{id}/detail', App\Http\Livewire\Dispatching\Pages\DetailDispatchingPage::class)
            ->name('dispatching.detail');
    });

    // Route::prefix('/stock-opname')->group(function() {
    //     Route::get('/', App\Http\Livewire\StockOpname\Pages\IndexPage::class)
    //         ->name('stock-opname.index');
    //     Route::get('/add', App\Http\Livewire\StockOpname\Pages\AddStockOpnamePage::class)
    //         ->name('stock-opname.add')
    //         ->middleware('permission:goods-transaction.create');
    //     Route::get('/{id}/detail', App\Http\Livewire\StockOpname\Pages\DetailStockOpnamePage::class)
    //         ->name('stock-opname.detail');
    // });

    // Route::prefix('/transaction-categories')->group(function() {
    //     Route::get('/', App\Http\Livewire\TransactionCategory\Pages\IndexPage::class)
    //         ->name('transaction-category.index')
    //         ->middleware('permission:goods-transaction-category.view');
    //     Route::get('/add', App\Http\Livewire\TransactionCategory\Pages\AddTransactionCategory::class)
    //         ->name('transaction-category.add')
    //         ->middleware('permission:goods-transaction-category.create');
    //     Route::get('{id}/edit', App\Http\Livewire\TransactionCategory\Pages\AddTransactionCategory::class)
    //         ->name('transaction-category.edit')
    //         ->middleware('permission:goods-transaction-category.update');
    // });

    // Route::prefix('/print-pdf')->controller(\App\Http\Controllers\PrintPDFController::class)->group(function () {
    //     Route::get('/receiving-detail/{id}', 'receivingDetail')
    //         ->name('print-pdf.receiving-detail');
    //     Route::get('/dispatching-detail/{id}', 'dispatchingDetail')
    //         ->name('print-pdf.dispatching-detail');
    //     Route::get('/stock-opname-detail/{id}', 'stockOpnameDetail')
    //         ->name('print-pdf.stock-opname-detail');
    // })->middleware(['role:Super Admin']);

    // Route::prefix('/roles')->group(function() {
    //     Route::get('/', App\Http\Livewire\User\Pages\RoleIndexPage::class)
    //         ->name('role.index');
    //     Route::get('/add', App\Http\Livewire\User\Pages\RoleAddPage::class)
    //         ->name('role.add');
    //     Route::get('{id}/edit', App\Http\Livewire\User\Pages\RoleAddPage::class)
    //         ->name('role.edit');
    // })->middleware(['role:Super Admin']);
// });

