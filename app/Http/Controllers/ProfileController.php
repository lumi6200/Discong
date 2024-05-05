<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $posts = $user->post;

        return view('profile', ['user' => $user, 'posts' => $posts]);
    }

    public function updatePost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            session()->flash('error', 'Update failed, password incorrect.');
            return redirect()->route('profile');
        }

        $user->update([
            'email' => $request->email,
            'password' => $request->new_password,
        ]);

        session()->flash('success', 'Account update successfully!');
        return redirect()->route('profile');
    }

    public function delete()
    {
        $user = auth()->user();
        $user->delete();
        
        session()->flash('success', 'Account deleted successfully!');
        return redirect()->route('home');
    }

    public function update(Request $request, Post $post){
        $request->validate([
            'heading' => 'required',
            'body' => 'required'
        ]);

        $post->update([
            'heading' => $request->heading,
            'body' => $request->body,
        ]);

        session()->flash('success', 'Post updated successfully!');
        return redirect()->route('profile');
    }
    public function deletePost(Post $post){
        $post->delete();

        session()->flash('success', 'Post deleted successfully!');
        return redirect()->route('profile');
    }
}
