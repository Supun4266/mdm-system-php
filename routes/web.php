<?php

  use App\Http\Controllers\BrandController;
  use App\Http\Controllers\CategoryController;
  use App\Http\Controllers\ItemController;
  use Illuminate\Support\Facades\Route;

  Route::get('/', function () {
      return redirect()->route('login');
  });

  Route::middleware(['auth'])->group(function () {
      Route::get('/home', function () {
          return view('home');
      })->name('home');

      Route::resource('brands', BrandController::class);
      Route::resource('categories', CategoryController::class);
      Route::resource('items', ItemController::class);

      Route::get('items/export/csv', [ItemController::class, 'exportCsv'])->name('items.export.csv');
      Route::get('items/export/excel', [ItemController::class, 'exportExcel'])->name('items.export.excel');
      Route::get('items/export/pdf', [ItemController::class, 'exportPdf'])->name('items.export.pdf');
  });

  require __DIR__.'/auth.php';
