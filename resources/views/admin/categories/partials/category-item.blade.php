<tr>
    <td>{{ $category->id }}</td>
    <td>
        @if ($category->image)
            <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                style="width: 100px; height: auto; border-radius: 0;">
        @else
            <span class="text-muted">無圖片</span>
        @endif
    </td>
    <td>
        {!! str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) !!}
        {!! $level > 0 ? '└ ' : '' !!}
        {{ $category->name }}
    </td>
    <td>{{ $category->sort_order }}</td>
    <td>{{ $category->products_count }}</td>
    <td>
        <div class="btn-group">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">編輯</a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                onsubmit="return confirm('確定要刪除此分類嗎？');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">刪除</button>
            </form>
        </div>
    </td>
</tr>

@if ($category->children->count() > 0)
    @foreach ($category->children as $child)
        @include('admin.categories.partials.category-item', [
            'category' => $child,
            'level' => $level + 1,
        ])
    @endforeach
@endif
