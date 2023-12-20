<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;


class ReverseSearchController extends Controller
{
    public function reverseSearch(Request $request){

        // Get search criteria from the request
        $searchData = $request->input('searchData', []);

        // Start building the query on the "Item" model
        $query = Item::query();

        // Loop through each search criteria
        foreach ($searchData as $criteria) {
            $field = $criteria['field'];
            $values = explode(',', $criteria['value']);

            // Use a where clause to find records that do not match the specified values for each field
            $query->where(function ($query) use ($field, $values) {
                foreach ($values as $value) {
                    $query->where($field, 'NOT LIKE', '%' . $value . '%');
                }
            });
        }

        // Execute the query and get the results
        $results = $query->get();

        // Return the results as a JSON response
        return response()->json($results);
    }

}
