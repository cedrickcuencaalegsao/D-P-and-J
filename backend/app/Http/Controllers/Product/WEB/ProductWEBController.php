<?php

namespace App\Http\Controllers\Product\WEB;

use App\Application\Category\RegisterCategory;
use App\Application\Product\RegisterProduct;
use App\Application\Sales\RegisterSales;
use App\Application\Stock\RegisterStock;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductWEBController extends Controller
{
    private RegisterProduct $registerProduct;
    private RegisterCategory $registerCategory;
    private RegisterStock $registerStock;
    private RegisterSales $registerSales;

    public function __construct(RegisterProduct $registerProduct, RegisterCategory $registerCategory, RegisterStock $registerStock, RegisterSales $registerSales)
    {
        $this->registerProduct = $registerProduct;
        $this->registerCategory = $registerCategory;
        $this->registerStock = $registerStock;
        $this->registerSales = $registerSales;
    }
    public function getProducts(): array
    {
        $productModel = $this->registerProduct->findAll();

        if (!$productModel) {
            return [];
        }

        return array_map(
            fn($productModel) =>
            $productModel->toArray(),
            $productModel
        );
    }
    /**
     * View Products.
     * **/
    public function index()
    {
        $data = $this->getProducts();
        // dd($data);
        return view('Pages.Product.index', compact('data'));
    }
    /**
     * Add Product.
     * **/
    public function addProduct(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validate->fails()) {
            return redirect('/products')->with('error', 'Please fill all the fields');
        }
        $product_id = $this->generateUniqueProductID();
        $retailed_price = $this->increasePriceByFivePercent($request->price);

        if ($request->file('image')) {
            $image = $request->file('image');
            $destinationPath = 'images';
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        // Create the product on database.
        $this->registerProduct->create(
            $product_id,
            $request->name,
            $request->price,
            $retailed_price,
            $data['image'],
        );

        // Call the function to save the category on database.
        $this->saveNewCategory($product_id, $request->category);
        $this->saveProductStock($product_id, 0);
        return redirect('/products')->with('success', 'Product added successfully');
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
    public function updateProduct(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'nullable|image',
        ]);
        if ($validate->fails()) {
            return redirect('/products')->with('error', 'Please fill all the fields');
        }

        $data = $request->all();
        $retailed_price = $this->increasePriceByFivePercent($request->price);

        $existingProduct = $this->registerProduct->findByProductID($data['product_id']);
        if (!$existingProduct) {
            return redirect('/products')->with('error', 'Product Not Found!');
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
            $retailed_price,
            $data['image'],
        );
        $this->saveProductSales(
            0,
            0,
            $data['product_id'],
            $this->increasePriceByFivePercent($request->price),
            $request->price
        );
        $this->updateCategory(
            $data['product_id'],
            $data['category'],
            Carbon::now()->toDateTimeString(),
        );
        return redirect('/products')->with('success', 'Product updated successfully');
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
