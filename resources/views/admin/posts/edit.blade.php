@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">編輯文章</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">標題</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $post->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">分類</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id" required>
                                    <option value="">請選擇分類</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">內容 (Markdown 語法)</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">封面圖片</label>
                                @if ($post->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/posts/' . $post->id . '/' . $post->image) }}"
                                            alt="當前圖片" style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                <div class="form-text">支援 jpg、png、gif 格式，檔案大小不超過 4MB</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sort_order" class="form-label">排序</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                    id="sort_order" name="sort_order" value="{{ old('sort_order', $post->sort_order) }}"
                                    min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $post->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="is_active">啟用</label>
                            </div>

                            <div class="mb-3">
                                <label for="seo_title" class="form-label">SEO 標題</label>
                                <input type="text" class="form-control @error('seo_title') is-invalid @enderror"
                                    id="seo_title" name="seo_title" value="{{ old('seo_title', $post->seo_title) }}">
                                <div class="form-text">建議在 70 個字元以內</div>
                                @error('seo_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="seo_description" class="form-label">SEO 描述</label>
                                <textarea class="form-control @error('seo_description') is-invalid @enderror" id="seo_description"
                                    name="seo_description" rows="3">{{ old('seo_description', $post->seo_description) }}</textarea>
                                <div class="form-text">建議在 155 個字元以內</div>
                                @error('seo_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="seo_keywords" class="form-label">SEO 關鍵字</label>
                                <input type="text" class="form-control @error('seo_keywords') is-invalid @enderror"
                                    id="seo_keywords" name="seo_keywords"
                                    value="{{ old('seo_keywords', $post->seo_keywords) }}">
                                <div class="form-text">多個關鍵字請用逗號分隔</div>
                                @error('seo_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    更新文章
                                </button>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                                    返回列表
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
@endpush

@push('scripts')
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script>
        const easyMDE = new EasyMDE({
            element: document.getElementById('content')
        });

        $(document).ready(function() {

            $('form').on('submit', function(e) {
                const content = editor.getData();
                if (!content.trim()) {
                    e.preventDefault();
                    alert('請填寫文章內容');
                    return false;
                }
                $('#content').val(content);
            });
        });
    </script>
@endpush
