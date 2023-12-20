<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function deleteUser($id){
        $user = Item::find($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
