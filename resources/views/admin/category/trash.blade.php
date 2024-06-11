@extends('admin.master')
@section('title')
    Quản lý danh mục
@endsection
@section('main-content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="card-header">
                                <h4 class="card-title mb-0">Add, Edit & Remove</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="listjs-table" id="customerList">
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm-auto">
                                            <a href="{{ route('category.index') }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                    height="20" width="17.5"
                                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path
                                                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                                                </svg></a>
                                            <div>
                                                <button type="button" class="btn btn-success add-btn"
                                                    data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i
                                                        class="ri-add-line align-bottom me-1"></i> <a
                                                        href="{{ route('category.create') }}">Add</a></button>
                                                {{-- <a href="{{ route('category.trash') }}" class="btn btn-soft-danger"><i
                                                        class="ri-delete-bin-2-line"></i></a> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="search-box ms-2">
                                                    <input type="text" class="form-control search"
                                                        placeholder="Search...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-card mt-3 mb-1">
                                        <table class="table align-middle table-nowrap" id="customerTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col" style="width: 50px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                                value="option">
                                                        </div>
                                                    </th>
                                                    <th class="sort" data-sort="customer_name">Mã loại</th>
                                                    <th class="sort" data-sort="email">Tên loại</th>
                                                    <th class="sort" data-sort="email">trạng thái</th>
                                                    <th class="sort" data-sort="email">Ngày tạo</th>

                                                    <th class="sort" data-sort="action">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($categories as $item)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="chk_child" value="option1">
                                                            </div>
                                                        </th>
                                                        <td class="id" style="display:none;"><a
                                                                href="javascript:void(0);"
                                                                class="fw-medium link-primary"></a>
                                                        </td>
                                                        <td class="customer_name">{{ $item->id }}</td>
                                                        <td class="customer_name">{{ $item->name }}</td>
                                                        <td class="customer_name">{!! $item->status
                                                            ? '<span class="label label-success">hiển thị</span>'
                                                            : '<span class="label label-warning">Ẩn</span>' !!}</td>

                                                        <td class="customer_name">{{ $item->deleted_at }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <div class="edit">
                                                                    <a href="{{ route('category.restore', $item->id) }}"
                                                                        class="btn btn-sm btn-success edit-item-btn">Khôi
                                                                        phục</a>
                                                                </div>

                                                                <div class="remove">
                                                                    <a href="{{ route('category.permanentlyDelete', $item->id) }}"
                                                                        class="btn btn-sm btn-danger remove-item-btn"
                                                                        onclick="return confirm('Are you sure?')">Remove</a>
                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end card -->
                            {{ $categories->links() }}
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- {{}} --}}
