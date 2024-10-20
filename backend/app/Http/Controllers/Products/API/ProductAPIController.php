<?php

namespace App\Http\Controllers\Products\API;

use App\Application\Product\RegisterProduct;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductAPIController extends Controller
{
    private RegisterProduct $registerProduct;

    /**
     * Constructor.
     **/
    public function __construct(RegisterProduct $registerProduct)
    {
        $this->registerProduct = $registerProduct;
    }
    /**
     * Get all products.
     **/
    public function getAll()
    {
        $productModel = $this->registerProduct->findAll();
        $products = array_map(fn($productModel) => $productModel->toArray(), $productModel);
        return response()->json(compact('products'), 200);
    }
    /**
     * Get by product ID.
     **/
    public function getByProductID(string $product_id)
    {
        $productModel = $this->registerProduct->findByProductID($product_id);
        if (!$productModel) {
            return response()->json(['message' => 'Product Not Found!', 'id' => $product_id], 404);
        }
        $tool = $productModel->toArray();
        return response()->json(compact('tool'));
    }
    /**
     * Create a new Product and add it on database table.
     **/
    public function addProduct(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'name' => 'required',
            'price' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => 'Invalid Products.'], 422);
        }
        $product_id = $this->generateUniqueProductID();
        $created_at = Carbon::now()->toDateTimeString();
        $updated_at = Carbon::now()->toDateTimeString();
        $this->registerProduct->create(
            $product_id,
            $request->name,
            $request->price,
            $created_at,
            $updated_at,
        );
        return response()->json(compact('data'));
    }
    /**
     * Validate the new Product ID. (it must be unique on the table.)
     **/
    private function generateUniqueProductID(): string
    {
        do {
            $product_id = $this->generateRandomAlphanumericID(15);
        } while ($this->registerProduct->findByProductID($product_id !== null));

        return $product_id;
    }
    /**
     * Generate Random 15 digit string will be use as Product id of the new product added.
     **/
    private function generateRandomAlphanumericID(int $lenght = 15): string
    {
        return substr(bin2hex(random_bytes($lenght / 2)), 0, $lenght);
    }
    /**
     * Update the product.
     **/
    public function updateProduct(Request $request, string $product_id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => 'Invalid product update. Please try again.'], 422);
        }
        $existingProduct = $this->registerProduct->findByProductID($product_id);
        if (!$existingProduct) {
            return response()->json(['message' => 'Product not Found!'], 404);
        }
        $updated_at = Carbon::now()->toDateTimeString();

        $this->registerProduct->update(
            $existingProduct->getId(),
            $product_id,
            $request->name,
            $request->price,
            $updated_at,
        );
        return response()->json(['message' => 'Updated successfully'], 200);
    }
}
