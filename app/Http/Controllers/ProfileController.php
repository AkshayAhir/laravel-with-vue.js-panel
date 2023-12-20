<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Test;

class ProfileController extends Controller
{
    public function updateUserData(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:tests,email,' . $request->id,
            'phone' => 'required|digits:10',
            // 'password' => 'sometimes|required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        // Custom validation for email format (must contain @ symbol)
        $validator->sometimes('email', 'regex:/^.+@.+\..+$/', function ($input) {
            return strpos($input->email, '@') !== false;
        });

        // If validation fails, return the validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If validation passes, update the user data
        $data = Test::find($request->id);
        $data->firstname = $request->firstname;
        $data->lastname = $request->lastname;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $request->email . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('image', $imageName, 'public');
            $data->image = $imageName;
        }

        if ($request->filled('password')) {
            $data->password = $request->password;
        }

        $data->save();
        return response()->json(['message' => 'User update successfully'], 200);
    }
}
