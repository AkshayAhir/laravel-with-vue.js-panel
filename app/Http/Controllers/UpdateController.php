<?php

namespace App\Http\Controllers;

use App\Models\Item;

use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updateUser(Request $request, $id)

    {
        // Find the user data by ID
        $data = Item::find($id);

        // Check if the user with the given ID exists
        if (!$data) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update user data fields
        $data->firstname = $request->firstname;
        $data->lastname = $request->lastname;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->phone = $request->phone;

        // Check if a new image file is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate a unique image name using the user's email and timestamp
            $imageName = $request->email . time() . '.' . $image->getClientOriginalExtension();

            // Store the image in the 'image' directory under the 'public' disk
            $image->storeAs('image', $imageName, 'public');

            // Update the 'image' field in the database with the new image name
            $data->image = $imageName;
        }

        // Save the updated user data
        $data->save();

        // Return the updated user data with the image path
        return response()->json(['message' => 'User updated successfully', 'image' => $data->image], 200);
    }



}
