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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            return response()->json(['message' => 'Authentication successful', 'user' => $user], 200);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
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
                    'role'=>2
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
        // You can customize the email sending logic based on your email provider
        // For example, using Laravel's built-in Mail facade
        Mail::send('emails.reset_password', ['newPassword' => $newPassword], function ($message) use ($email) {
            $message->to($email)->subject('Your New Password');
        });
    }


    public function checkUserExists(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            // If email parameter is not present in the request
            return response()->json(['error' => 'Email parameter is required'], 400);
        }

        $userExists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $userExists], 200);
    }
}
