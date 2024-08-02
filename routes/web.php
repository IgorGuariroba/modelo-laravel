<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/up', function () {
    $databaseConnection = true;
    $databaseVersion = '';
    $status = 'OK';


    // Verifica a conexão com o banco de dados
    try {
        $databaseVersion = DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION);

    } catch (\Exception $exception) {
        $databaseConnection = false;
        $status = false;
    }

    // Verifica a conexão com o cache
    try {
        Cache::store()->get('key');
        $cacheConnection = true;
    } catch (\Exception $e) {
        $cacheConnection = false;
        $status = false;
    }

    return response()->json([
        'status' => $status,
        'database' => [
            'connected' => $databaseConnection,
            'version' => $databaseVersion,
        ],
        'cache' => [
            'connected' => $cacheConnection,
        ],
        'app' => [
            'version' => app()->version(),
            'environment' => app()->environment(),
        ],
    ]);

});
