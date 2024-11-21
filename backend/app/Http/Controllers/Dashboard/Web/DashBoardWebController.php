<?php

namespace App\Http\Controllers\Dashboard\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardWebController extends Controller
{
    /**
     * View Dashboard.
     * **/
    public function viewDashBoard()
    {
        return view('Pages.DashBoard.index');
    }
}
