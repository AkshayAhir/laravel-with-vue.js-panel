<?php

namespace App\Http\Controllers;

// use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchData = $request->input('searchData');

        // Perform field-wise search
        $query = DB::table('items'); // Replace 'users' with your actual table name

        foreach ($searchData as $data) {
            $field = $data['field'];
            $value = $data['value'];

            // Add conditions to the query based on the field and value
            $query->where($field, 'LIKE', '%' . $value . '%');
        }

        // Execute the query and get the results
        $results = $query->get();

        return response()->json($results);
    }
}

