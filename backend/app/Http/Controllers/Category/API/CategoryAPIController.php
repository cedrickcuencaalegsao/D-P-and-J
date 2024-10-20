<?php

namespace App\Http\Controllers\Category\API;

use App\Application\Category\RegisterCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryAPIController extends Controller
{
    private RegisterCategory $registerCategory;

    public function __construct(RegisterCategory $registerCategory)
    {
        $this->registerCategory = $registerCategory;
    }
    public function getAll()
    {
        $categoryModel = $this->registerCategory->findAll();
        $categories = array_map(fn($categoryModel) => $categoryModel->toArray(), $categoryModel);
        return response()->json(compact('categories'), 200);
    }
}
