<?php

namespace App\Http\Controllers\Category\Web;

use App\Application\Category\RegisterCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryWebController extends Controller
{
    private RegisterCategory $registerCategory;
    public function __construct(RegisterCategory $registerCategory)
    {
        $this->registerCategory = $registerCategory;
    }
    /**
     * View Category.
     * **/
    public function index()
    {
        $data = $this->registerCategory->findAll();
        return view("Pages.Category.index", compact("data"));
    }
}
