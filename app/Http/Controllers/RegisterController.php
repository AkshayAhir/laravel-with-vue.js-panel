<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Define custom error messages
        $messages = [
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Invalid email address format.',
            'email.unique' => 'Email address is already in use.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters long.',
            'phone.required' => 'Phone number is required.',
            'phone.numeric' => 'Phone number must be numeric.',
            'phone.digits' => 'Phone number must be 10 digits long.',
        ];

        // Validate user input
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:tests,email',
            'password' => 'required|string|min:6|confirmed', // Add |confirmed rule
            'phone' => 'required|numeric|digits:10',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create a new Test model instance and populate its fields
        $test = new Test;
        $test->firstname = $request->input('firstname');
        $test->lastname = $request->input('lastname');
        $test->email = $request->input('email');
        // Password is stored in plain text (not recommended for security)
        $test->password = $request->input('password');
        $test->phone = $request->input('phone');

        // Handle image upload
        if ($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for image files
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $image = $request->file('image');

            $imageName = $request->email . '_' . time() . '.' . $image->getClientOriginalExtension();

            $image->storeAs('image', $imageName, 'public'); // Store in the 'images' directory

            $test->image = $imageName;
        }

        $test->save();

        // Retrieve the user data after saving to the database
        $user = Test::where('email', $request->input('email'))->first();

        // You can customize the response data as needed
        return response()->json(['message' => 'Registration successful', 'user' => $user], 200);
    }

}
