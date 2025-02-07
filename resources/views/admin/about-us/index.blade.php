@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>關於我們管理</h2>
            @if (!$aboutUs)
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.about-us.create') }}" class="btn btn-primary">新增關於我們</a>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th>標題</th>
                            <th>圖片</th>
                            <th>內容預覽</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($aboutUs)
                            <tr>
                                <td>{{ $aboutUs->id }}</td>
                                <td>{{ $aboutUs->title }}</td>
                                <td>
                                    <img src="{{ asset('storage/about-us/' . $aboutUs->image) }}" alt="關於我們圖片"
                                        style="max-width: 100px">
                                </td>
                                <td>{{ Str::limit(strip_tags(Str::markdown($aboutUs->content)), 100) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.about-us.edit', $aboutUs) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/2.1.8/i18n/zh-HANT.json"
                },
                responsive: true,
                ordering: false,
            });
        });
    </script>
@endpush
