<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProducts(Request $request): JsonResponse
    {
        try {
            $client = auth('api')->user();

            $clientId = data_get($client, 'id');

            $type = data_get($request, 'type');

            $categoryType = CategoryType::where('user_id', $clientId)
                                ->with(['categories' => function ($query) use ($clientId) {
                                    $query->where('user_id', $clientId)->active()->orderBy('order');
                                }])
                                ->active()
                                ->where('slug', $type)
                                ->first();
            $data = [];

            if (! blank($categoryType)) {
                $data = CategoryResource::collection(data_get($categoryType, 'categories'));
            }

            return app(ApiResponse::class)->success($data, 'success.');
        } catch (\Exception $e) {
            Log::error($e);

            return app(ApiResponse::class)->error('Something went wrong');
        }
    }


    public function storeView(Product $product): bool
    {
        $item = $product->views()->create([
            'user_id' => data_get($product, 'user_id')
        ]);

        return (bool)$item;
    }
}

