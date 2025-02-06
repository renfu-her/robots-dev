<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Services\ImageService;

class NewsController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $news = News::latest('published_at')
            ->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|max:60',
            'meta_description' => 'nullable|max:160',
            'meta_keywords' => 'nullable|max:255'
        ]);

        // 創建最新消息
        $news = News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_active' => $request->has('is_active'),
            'published_at' => $validated['published_at'] ? Carbon::parse($validated['published_at']) : now(),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null
        ]);

        // 處理圖片上傳
        if ($request->hasFile('image')) {
            $filename = $this->imageService->uploadImage(
                $request->file('image'),
                "news/{$news->id}"
            );

            $news->update([
                'image' => $filename
            ]);
        }

        return redirect()
            ->route('admin.news.index')
            ->with('success', '最新消息已建立');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|max:60',
            'meta_description' => 'nullable|max:160',
            'meta_keywords' => 'nullable|max:255'
        ]);

        // 更新基本資料
        $news->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_active' => $request->has('is_active'),
            'published_at' => $validated['published_at'] ? Carbon::parse($validated['published_at']) : now(),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null
        ]);

        // 處理圖片上傳
        if ($request->hasFile('image')) {
            // 刪除舊圖片
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            // 上傳新圖片
            $filename = $this->imageService->uploadImage(
                $request->file('image'),
                "news/{$news->id}"
            );

            $news->update([
                'image' => $filename
            ]);
        }

        return redirect()
            ->route('admin.news.index')
            ->with('success', '最新消息已更新');
    }

    public function destroy(News $news)
    {
        // 刪除圖片
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
            // 刪除整個最新消息資料夾
            Storage::disk('public')->deleteDirectory("news/{$news->id}");
        }

        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', '最新消息已刪除');
    }

    public function toggleActive(News $news, Request $request)
    {
        $news->update([
            'is_active' => $request->is_active == 'true' ? 1 : 0
        ]);

        return response()->json([
            'success' => true,
            'message' => '狀態更新成功'
        ]);
    }
}
