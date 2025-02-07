<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first();
        return view('admin.about-us.index', compact('aboutUs'));
    }

    public function create()
    {
        return view('admin.about-us.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $aboutUs = new AboutUs();
        $aboutUs->title = $validated['title'];
        $aboutUs->content = $validated['content'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('about-us', $filename, 'public');
            $aboutUs->image = $filename;
        }

        $aboutUs->save();

        return redirect()->route('admin.about-us.index')
            ->with('success', '關於我們已成功創建！');
    }

    public function edit($id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        return view('admin.about-us.edit', compact('aboutUs'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $aboutUs = AboutUs::findOrFail($id);
        $aboutUs->title = $validated['title'];
        $aboutUs->content = $validated['content'];

        if ($request->hasFile('image')) {
            // 刪除舊圖片
            if ($aboutUs->image) {
                Storage::disk('public')->delete('about-us/' . $aboutUs->image);
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('about-us', $filename, 'public');
            $aboutUs->image = $filename;
        }

        $aboutUs->save();

        return redirect()->route('admin.about-us.index')
            ->with('success', '關於我們已成功更新！');
    }

    public function destroy($id)
    {
        $aboutUs = AboutUs::findOrFail($id);

        if ($aboutUs->image) {
            Storage::disk('public')->delete('about-us/' . $aboutUs->image);
        }

        $aboutUs->delete();

        return redirect()->route('admin.about-us.index')
            ->with('success', '關於我們已成功刪除！');
    }
}
