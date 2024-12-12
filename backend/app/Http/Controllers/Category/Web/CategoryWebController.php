<?php

namespace App\Http\Controllers\Category\WEB;

use App\Application\Category\RegisterCategory;
use App\Http\Controllers\Controller;
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
}
