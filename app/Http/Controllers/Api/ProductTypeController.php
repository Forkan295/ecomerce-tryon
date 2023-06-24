<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductTypeResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Models\CategoryType;

class ProductTypeController extends Controller
{
    public function getProductTypes(): JsonResponse
    {
        try {
            $client = auth('api')->user();

            $clientId = data_get($client, 'id');

            $productTypes = CategoryType::where('user_id', $clientId)->active()->get();

            $data = new ProductTypeResource($productTypes);

            return app(ApiResponse::class)->success($data, 'success.');
        } catch (\Exception $e) {
            Log::error($e);

            return app(ApiResponse::class)->error('Something went wrong');
        }
    }
}

