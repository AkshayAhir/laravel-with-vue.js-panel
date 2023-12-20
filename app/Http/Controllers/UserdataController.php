<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;

class UserdataController extends Controller
{
    public function userdata(Request $request)
    {


        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $item = Item::create($request->all());



        return response()->json(['message' => 'Data saved successfully', 'data' => $item], 201);
    }

    public function fetchUserData()
    {
        $userData = Item::all(); // Replace with your actual data retrieval logic

        return response()->json($userData, 200);
    }

}
