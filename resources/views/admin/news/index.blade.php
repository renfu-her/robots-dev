@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>最新消息管理</h2>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">新增最新消息</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-responsive" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th>標題</th>
                            <th>圖片</th>
                            <th>發布時間</th>
                            <th>狀態</th>
                            <th>創建時間</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    @if ($item->image)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                            style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">無圖片</span>
                                    @endif
                                </td>
                                <td>{{ $item->published_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input type="checkbox" class="form-check-input toggle-status"
                                            data-id="{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.news.edit', $item) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('確定要刪除此最新消息嗎？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                刪除
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table td img,
        .jsgrid .jsgrid-table td img {
            width: 150px !important;
            height: auto !important;
            border-radius: 0 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/2.1.8/i18n/zh-HANT.json"
                },
                responsive: true,
                order: [
                    [3, 'desc']
                ],
                columnDefs: [{
                    targets: [4, 6],
                    orderable: false
                }]
            });

            // 切換狀態
            $('.toggle-status').on('change', function() {
                const id = $(this).data('id');
                const isActive = $(this).prop('checked');

                $.ajax({
                    url: `/admin/news/${id}/toggle-active`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_active: isActive
                    },
                    success: function(response) {
                        if (response.success) {
                            // 可以添加成功提示
                        }
                    },
                    error: function() {
                        // 發生錯誤時恢復原狀態
                        $(this).prop('checked', !isActive);
                    }
                });
            });
        });
    </script>
@endpush
