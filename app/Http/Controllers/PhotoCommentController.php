<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\DogPhoto;
use App\Models\User;
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
            'content' => ['required', 'string', 'min:2', 'max:255'],
        ]);

        $comment = new Comment($data);
        $comment->author()->associate($request->user());
        $comment->photo()->associate($photo);
        $comment->save();

        return new CommentResource($comment);   
    }
}
