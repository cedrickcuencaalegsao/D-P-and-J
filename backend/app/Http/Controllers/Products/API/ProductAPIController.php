<?php

namespace App\Http\Controllers\Products\API;

use App\Application\Product\RegisterProduct;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Application\Category\RegisterCategory;
use App\Application\Sales\RegisterSales;
use App\Application\Stock\RegisterStock;
use Illuminate\Support\Facades\File;

class ProductAPIController extends Controller
{
    private RegisterProduct $registerProduct;
    private RegisterCategory $registerCategory;
    private RegisterStock $registerStock;
    private RegisterSales $registerSales;

    /**
     * Constructor.
     **/
    public function __construct(RegisterProduct $registerProduct, RegisterCategory $registerCategory, RegisterStock $registerStock, RegisterSales $registerSales)
    {
        $this->registerProduct = $registerProduct;
        $this->registerCategory = $registerCategory;
        $this->registerStock = $registerStock;
        $this->registerSales = $registerSales;
    }
    /**
     * Get all products.
     **/
    public function getAll(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        try {
            $productModel = $this->registerProduct->findAll();
            if (!$productModel) {
                return response()->json(['message' => "No products found."], 404);
            }
            $products = array_map(fn($productModel) => $productModel->toArray(), $productModel);
            return response()->json(compact('products'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
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
            return response()->json($validate->errors(), 422);
            // return response()->json(['message' => 'Invalid Products.'], 422);
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
        $this->saveNewCategory($product_id, $request->category);
        $this->saveProductStock($product_id, $request->stock);
        $this->saveProductSales(
            $request->item_sold,
            $request->total_sale,
            $product_id,
            $this->increasePriceByFivePercent($request->price),
            $request->price
        );

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
    public function updateProduct(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'nullable|image',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $data = $request->all();

        $existingProduct = $this->registerProduct->findByProductID($data['product_id']);
        if (!$existingProduct) {
            return response()->json(['message' => 'Product Not Found!', 'id' => $data['product_id']], 404);
        }
        // Handle image upload if provided
        if ($request->file('image')) {
            // Delete old image if it's not the default image
            if ($existingProduct->getImage() !== 'default.jpg') {
                File::delete('images/' . $existingProduct->getImage());
            }

            $image = $request->file('image');
            $destinationPath = 'images';
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            if ($existingProduct->getImage() === null) {
                $data['image'] = 'default.jpg';
            } else {
                $data['image'] = $existingProduct->getImage();
            }
        }
        $this->registerProduct->update(
            $data['product_id'],
            $data['name'],
            $data['price'],
            $data['image'],
            Carbon::now()->toDateTimeString(),
        );
        $this->updateCategory(
            $data['product_id'],
            $data['category'],
            Carbon::now()->toDateTimeString(),
        );
        return response()->json(true, 200);
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
    public function saveNewCategory(string $product_id, string $category)
    {
        $this->registerCategory->create(
            $product_id,
            $category,
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );
    }
    /**
     * Update the category on database.
     **/
    public function updateCategory(string $product_id, string $category, string $updated_at)
    {
        $this->registerCategory->update(
            $product_id,
            $category,
            $updated_at,
        );
    }
    /**
     * add Product Stock to database, for newly added products only.
     * **/
    public function saveProductStock(string $product_id, int $stock)
    {
        $this->registerStock->create(
            $product_id,
            $stock,
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );
    }
    /**
     * add Product sales to database, for newly added products only.
     * **/
    public function saveProductSales(int $item_sold, float $total_sale, string $product_id, float $retailed_price, float $retrieve_price)
    {

        $this->registerSales->create(
            $item_sold,
            $product_id,
            $retailed_price,
            $retrieve_price,
            $total_sale,
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );
    }
    /**
     * increase by 5% for income.
     * **/
    public function increasePriceByFivePercent(float $price)
    {
        return $price * 1.05;
    }
}
