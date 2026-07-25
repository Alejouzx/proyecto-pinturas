Route::get('/productos', [ProductoController::class, 'index']);
Route::post('/productos', [ProductoController::class, 'store']);
Route::get('/productos/{id}', [ProductoController::class, 'show']);
Route::put('/productos/{id}', [ProductoController::class, 'update']);
Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);

Route::get('/pedidos', [PedidoController::class, 'index']);
Route::post('/pedidos', [PedidoController::class, 'store']);
Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
Route::put('/pedidos/{id}', [PedidoController::class, 'update']);

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);