<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Element;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ElementController extends Controller
{
    public function index(Request $request) {
        $elements = Element::get();
        return response()->json([
            'elements' => $elements,
            'success' => true,
            'message' => 'Elements Fetched Successfully'
        ], 200);
    }

}
