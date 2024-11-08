<?php

namespace App\Http\Controllers\Products\API;

use App\Application\Product\RegisterProduct;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Application\Category\RegisterCategory;

class ProductAPIController extends Controller
{
    private RegisterProduct $registerProduct;
    private RegisterCategory $registerCategory;

    /**
     * Constructor.
     **/
    public function __construct(RegisterProduct $registerProduct, RegisterCategory $registerCategory)
    {
        $this->registerProduct = $registerProduct;
        $this->registerCategory = $registerCategory;
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
        $product = $productModel->toArray();
        return response()->json(compact('product'));
    }
    /**
     * Create a new Product and add it on database table.
     **/
    public function addProduct(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'nullable',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => 'Invalid Products.'], 422);
        }
        $product_id = $this->generateUniqueProductID();
        if ($request->file('image')) {
            // Get the image from the request.
            $image = $request->file('image');
            $destinationPath = 'images';

            // Renaming the image with the time of upload.
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);

            // the image name will be saved on database.
            $data['image'] = $imageName;
        } else {
            // if there is no image, the default image will be saved on database.
            $data['image'] = 'default.jpg';
        }
        // Create the product on database.
        $this->registerProduct->create(
            $product_id,
            $request->name,
            $request->price,
            $data['image'],
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString(),
        );
        // Call the function to save the category on database.
        $this->saveCategory($product_id, $request->category);

        return response()->json(['message' => 'Created successfully'], 201);
    }
    /**
     * Validate the new Product ID. (it must be unique on the table.)
     **/
    private function generateUniqueProductID(): string
    {
        do {
            $product_id = $this->generateRandomAlphanumericID(15);
        } while ($this->registerProduct->findByProductID($product_id));

        return $product_id;
    }
    /**
     * Generate Random 15 digit string, that will be use as Product id of the new product added.
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
    /**
     * Search the product by name.
     **/
    public function searchProduct(Request $request)
    {
        $search = $request->input('searched');
        if (!$search) {
            return null;
        }

        $result = $this->registerProduct->search($search);

        if (is_null($result['match'] && empty($result['related']))) {
            return response()->json(['message' => 'No data found.']);
        }

        return response()->json(compact('result'));
    }
    /**
     * Save the category on database.
     **/
    public function saveCategory(string $product_id, string $category)
    {
        $this->registerCategory->create(
            $product_id,
            $category,
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );
    }
}
