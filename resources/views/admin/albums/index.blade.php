@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>相簿管理</h2>
            <a href="{{ route('admin.albums.create') }}" class="btn btn-primary">新增相簿</a>
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
                            <th>狀態</th>
                            <th>創建時間</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($albums as $album)
                            <tr>
                                <td>{{ $album->id }}</td>
                                <td>{{ $album->title }}</td>
                                <td>
                                    @if ($album->image)
                                        <img src="{{ Storage::url($album->image) }}" alt="{{ $album->title }}"
                                            style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">無圖片</span>
                                    @endif
                                </td>
                                <td>{{ $album->status ? '啟用' : '停用' }}</td>
                                <td>{{ $album->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.albums.edit', $album) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.albums.destroy', $album) }}" method="POST"
                                            onsubmit="return confirm('確定要刪除此相簿嗎？');">
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
                    [0, 'desc']
                ],
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
