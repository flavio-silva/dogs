<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\DogPhoto;
use Illuminate\Http\Request;

class PhotoCommentController extends Controller
{
    public function index(DogPhoto $photo)
    {
        return $photo->comments;
    }
    
    public function store(DogPhoto $photo, Request $request)
    {
        $data = $request->validate([
            'comment' => ['required', 'string', 'min:4', 'max:255'],
        ]);

        $comment = new Comment($data);
        $comment->photo()->associate($photo);
        $comment->save();

        return $comment;   
    }
}
