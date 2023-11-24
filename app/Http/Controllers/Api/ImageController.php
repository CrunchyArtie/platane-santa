<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'image' => ['required', 'image', 'max:10240'],
        ]);

        $file = $request->file('image');
        $filename = date('YmdHis') . '-' . $request->user_id . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/images', $filename);

        $user = $request->user();

        $image = new \App\Models\Image([
            'name' => $path,
        ]);

        $user->images()->save($image);

        return response()->json(['image' => $image->load('user')], 201);
    }

    public function show(Request $request, $id) {

        $image = \App\Models\Image::find($id);
        $file = storage_path('app/' . $image->name);
        $type = \Illuminate\Support\Facades\File::mimeType($file);
        $response = \Illuminate\Support\Facades\Response::make(\Illuminate\Support\Facades\File::get($file), 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function destroy(Request $request, $id) {

        $image = \App\Models\Image::find($request->id);
        $file = storage_path('app/' . $image->name);
        \Illuminate\Support\Facades\File::delete($file);

        $image->delete();

        return response(204);
    }
}
