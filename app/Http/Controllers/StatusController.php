<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Psr\SimpleCache\InvalidArgumentException;

class StatusController extends Controller
{
    public function getStatus(): JsonResponse
    {
        $databaseConnection = true;
        $databaseVersion = '';
        $cacheConnection = true;
        $status = 'OK';

        // Verifica a conexão com o banco de dados
        try {
            $databaseVersion = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);
        } catch (\PDOException $exception) {
            $databaseConnection = false;
            $status = 'FAIL';
        }

        // Verifica a conexão com o cache
        try {
            if (!Cache::store()->has('key')) {
                Cache::store()->put('key', 'value');
            }
        } catch (\Exception|InvalidArgumentException $e) {
            $cacheConnection = false;
            $status = 'FAIL';
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

    }
}
