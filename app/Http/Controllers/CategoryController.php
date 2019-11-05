<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProductTrackExport;
use App\ProductTrack;
use App\Shop;
use DB;
use DateTime;

class CategoryController extends Controller
{

  public function index(Request $request){

    return view('app.categories.index');

  }


}
