<?php

namespace App\Http\Controllers;

use App\Http\Resources\DogPhotoResource;
use App\Models\DogPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class DogPhotoController extends Controller
{
    public function index(Request $request)
    {
        $collection = QueryBuilder::for(DogPhoto::class)
        ->withCount(['comments'])
        ->with('owner:id,name')
            ->allowedFilters('name', 'age', 'weight', 'owner_id')
            ->allowedSorts('created_at')
            ->defaultSort('-created_at')
            ->jsonPaginate();

        return DogPhotoResource::collection($collection);
    }

    public function show(DogPhoto $photo)
    {
        $photo->load(['comments.author', 'owner:id,name']);
        
        $photo->views_count = $photo->views_count + 1;
        $photo->save();
        
        $photo->photo_url = Storage::disk('public')->url($photo->path);

        return $photo;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo' => ['required', 'image', 'max:20480'],
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0'],
            'age' => ['required', 'integer', 'min:0', 'max:40'],
        ]);



        // $path = $request->file('photo')->storePublicly('photos');

        $path = Storage::disk('public')->put('photos', $request->file('photo'));
        
        $photo = new DogPhoto($data);
        $photo->owner()->associate($request->user());
        $photo->path = $path;
        $photo->save();

        $photo->photo_url = Storage::disk('public')->url($path);
        return $photo;
    }

    public function update(DogPhoto $photo, Request $request)
    {
        $data = $request->validate([
            'photo' => ['required', 'image', 'max:1024'],
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0'],
            'age' => ['required', 'integer', 'min:0', 'max:40'],
        ]);

        Storage::delete($photo->path);

        $path = $request->file('photo')->storePublicly('photos');
        
        $photo = $photo->fill($data);
        $photo->owner()->associate($request->user());
        $photo->path = $path;
        $photo->save();

        $photo->photo_url = Storage::disk('public')->url($path);
        return $photo;
    }

    public function destroy(DogPhoto $photo)
    {
        Gate::authorize('delete', $photo);
        
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
        return response()->noContent();
    }
}
