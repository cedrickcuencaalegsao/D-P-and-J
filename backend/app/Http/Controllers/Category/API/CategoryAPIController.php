<?php

namespace App\Http\Controllers\Category\API;

use App\Application\Category\RegisterCategory;
use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Eloquent\Category\CategoryModel;
use Illuminate\Http\Request;

class CategoryAPIController extends Controller
{
    private RegisterCategory $registerCategory;
    /**
     * Constructor.
     **/
    public function __construct(RegisterCategory $registerCategory)
    {
        $this->registerCategory = $registerCategory;
    }
    /***
     * Get all Cetegories.
     **/
    public function getAll()
    {
        $categoryModel = $this->registerCategory->findAll();
        $categories = array_map(fn($categoryModel) => $categoryModel->toArray(), $categoryModel);
        return response()->json(compact('categories'), 200);
    }
    /**
     * Get by product ID.
     **/
    public function getByProductID(string $product_id)
    {
        $categoryModel = $this->registerCategory->findByProductID($product_id);
        if (!$categoryModel) {
            return response()->json(['message' => 'Product Not Found!', 'id' => $product_id], 404);
        }
        $category = $categoryModel->toArray();
        return response()->json(compact('category'));
    }
    public function addCategory(string $product_id, string $category){
        return response()->json(null);
    }
    /**
     * Search Category.
     **/
    public function search(Request $request)
    {
        $search = $request->input('searched');
        if (!$search) {
            return null;
        }
        $result = $this->registerCategory->search($search);

        if (is_null($result['match'] && empty($result['related']))) {
            return response()->json(['message' => 'No data found.']);
        }

        return response()->json(compact('result'));
    }
}
