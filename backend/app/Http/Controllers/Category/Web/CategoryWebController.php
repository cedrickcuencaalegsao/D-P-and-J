<?php

namespace App\Http\Controllers\Category\WEB;

use App\Application\Category\RegisterCategory;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryWEBController extends Controller
{
    private RegisterCategory $registerCategory;
    public function __construct(RegisterCategory $registerCategory)
    {
        $this->registerCategory = $registerCategory;
    }
    public function getCategory(): array
    {
        $categoryModel = $this->registerCategory->findAll();

        if (!$categoryModel) {
            return [];
        }

        return array_map(
            fn($categoryModel) => $categoryModel->toArray(),
            $categoryModel
        );
    }
    /**
     * View Category.
     * **/
    public function index()
    {
        $data = $this->getCategory();
        return view("Pages.Category.index", compact("data"));
    }
    /**
     * Update Category.
     * **/
    public function updateCategory(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $validateCategory = $this->registerCategory->findByProductID($data['product_id']);
        if (!$validateCategory) {
            return response()->json(['message' => 'Product Not Found!'], 404);
        }
        $this->registerCategory->update(
            $data['product_id'],
            $data['category'],
            Carbon::now()->toDateTimeString(),
        );
        return redirect()->route('category')->with('success', 'Category Updated Successfully!');
    }
}
