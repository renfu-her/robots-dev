@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">編輯最新消息</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">標題</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $news->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">內容</label>
                                <textarea class="form-control ckeditor5 @error('content') is-invalid @enderror" id="content" name="content">{{ old('content', $news->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                @if ($news->image)
                                    <div class="mb-3">
                                        <label class="form-label">目前圖片</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <img src="{{ $news->image_url }}" class="img-fluid rounded"
                                                    alt="{{ $news->title }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <label for="image" class="form-label">
                                    {{ $news->image ? '更換圖片' : '上傳圖片' }}
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="published_at" class="form-label">發布時間</label>
                                <input type="datetime-local"
                                    class="form-control @error('published_at') is-invalid @enderror" id="published_at"
                                    name="published_at"
                                    value="{{ old('published_at', $news->published_at?->format('Y-m-d\TH:i')) }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input p-1" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $news->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label p-1" for="is_active">啟用</label>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header">SEO 設定</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">SEO 標題</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            value="{{ old('meta_title', $news->meta_title) }}" maxlength="60">
                                        <small class="text-muted">建議長度：60 字元以內</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">SEO 描述</label>
                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $news->meta_description) }}</textarea>
                                        <small class="text-muted">建議長度：160 字元以內</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">SEO 關鍵字</label>
                                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                            value="{{ old('meta_keywords', $news->meta_keywords) }}">
                                        <small class="text-muted">多個關鍵字請用逗號分隔</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    更新最新消息
                                </button>
                                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
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

@include('admin.partials.ckeditor')
