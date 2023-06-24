<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories(): JsonResponse
    {
        $client = auth('api')->user();

        $clientId = data_get($client, 'id');

        try {
            $categories = Category::where('user_id', $clientId)->active()->get();

            $data = CategoryResource::collection($categories);

            return app(ApiResponse::class)->success($data, 'success.');
        } catch (\Exception $e) {
            Log::error($e);

            return app(ApiResponse::class)->error('Something went wrong');
        }
    }
}

