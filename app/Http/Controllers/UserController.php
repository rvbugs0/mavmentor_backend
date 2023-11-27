<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function store(Request $request)
    {
        return User::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return 204;
    }

    public function authenticate(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (!$email) {
            // If email parameter is not present in the request
            return response()->json(['success' => false, 'message' => 'Email parameter is required'], 200);
        }
        if (!$password) {
            // If email parameter is not present in the request
            return response()->json(['success' => false, 'message' => 'Password parameter is required'], 200);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            return response()->json(['success'=>true,'message' => 'Authentication successful', 'user' => $user], 200);
        } else {
            // Authentication failed
            return response()->json(['success'=>false,'message' => 'Invalid credentials'],200);
        }
    }


    public function generatePassword(Request $request)
    {   // Validate the request
        // Validate the request
        $request->validate([
            'email' => 'required|email',

            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        // Check if the email ends with ".uta.edu"
        if (Str::endsWith($request->email, '.uta.edu')) {
            // Try to find the user by email
            $user = User::where('email', $request->email)->first();

            // If the user doesn't exist, create a new user
            if (!$user) {
                $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make(Str::random(10)),
                    'role' => 2
                ]);
            }

            // Generate a new password
            $newPassword = Str::random(10); // You can use a more secure method to generate a password

            // Update the user's password in the database
            $user->password = Hash::make($newPassword);
            $user->save();

            // Send the new password to the user's email
            // $this->sendPasswordEmail($user->email, $newPassword);

            return response()->json(['message' => 'Password reset successfully. Check your email for the new password.'], 200);
        } else {
            return response()->json(['message' => 'Email must end with ".uta.edu" to reset the password.'], 400);
        }
    }

    private function sendPasswordEmail($email, $newPassword)
    {
        $subject = "New Password: ";
        $message = "Your new password: $newPassword";
        $headers = "From: admin@uta.edu";
        mail($email, $subject, $message, $headers);
    }


    public function checkUserExists(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            // If email parameter is not present in the request
            return response()->json(['success' => false, 'message' => 'Email parameter is required'], 200);
        }
        // Check if the email ends with ".uta.edu"
        if (!Str::endsWith($email, '.uta.edu')) {
            return response()->json(['success' => false, 'message' => 'Only email ending with .uta.edu allowed'], 200);
        }


        $userExists = User::where('email', $request->email)->exists();
        if ($userExists) {
            return response()->json(['success' => true, 'exists' => $userExists], 200);
        } else {



            // User does not exist, create a password
            $newPassword = Str::random(10);

            // Create a new user
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($newPassword),
                'role'=>2
            ]);

            // Send email with the new password
            $this->sendPasswordEmail($user->email, $newPassword);
            return response()->json(['success' => false, 'message' => "Password sent to your email. Retry logging in."], 200);
        }



    }

}
