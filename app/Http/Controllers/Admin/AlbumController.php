<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::orderBy('id', 'desc')->paginate(10);
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.albums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required'
        ]);


        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('albums', 'public');
            $data['image'] = $path;
        }

        Album::create($data);
        return redirect()->route('admin.albums.index')->with('success', '相簿創建成功！');
    }

    public function edit(Album $album)
    {
        return view('admin.albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required'

        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // 刪除舊圖片
            if ($album->image) {
                Storage::disk('public')->delete($album->image);
            }
            
            $file = $request->file('image');
            $path = $file->store('albums', 'public');
            $data['image'] = $path;
        }

        $album->update($data);
        return redirect()->route('admin.albums.index')->with('success', '相簿更新成功！');
    }
} 