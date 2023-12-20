<?php

namespace App\Http\Controllers;

use App\Models\Test; // Adjust the namespace if needed
use Illuminate\Http\Request;

class GetdataController extends Controller
{
    public function getUserData($Email)
    {

        $user = Test::where('email', $Email)->first();
        return response()->json($user);
    }
}
