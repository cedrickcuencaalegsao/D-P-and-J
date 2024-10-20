<?php

namespace App\Http\Controllers\Dashboard\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardWebController extends Controller
{
    public function viewDashBoard()
    {
        return view('Pages.DashBoard.index');
    }
}
