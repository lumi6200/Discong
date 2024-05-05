<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function home()
    {
        $posts = Post::all();
        return view("home", compact('posts'));
    }

    public function signUpPost(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user)
            session()->flash('success','Registration successful, log in to your new account!');

        return redirect()->route('home');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            session()->flash('success', 'Login successful!');
            return redirect()->route('home');
        }

        session()->flash('error', 'Login failed, Invalid credentials.');
        return back();
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', 'Logged out successfully!');
        return redirect()->route('home');
    }

    public function post(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:30',
            'body' => 'required|string|max:255'
        ]);

        $post = Post::create([
            'user_id' => auth()->user()->id,
            'heading' => $request->heading,
            'body' => $request->body,
        ]);

        if ($post)
            session()->flash('success', 'Posted successfully!');

        return redirect()->route('home');
    }

    public function profile(){
        return view('profile', ['user' => auth()->user()]);
    }
}
