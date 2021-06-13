@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Product') }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group pull-right">
                    <a class="btn btn-primary m-b-md" href="{{route('product.create')}}"> Add New</a>
                </div>
            </div>
        </div>
        <div class="table-responsive p-l-r-no">
            <table class="table responsive display no-wrap table-striped table-bordered table-hover dataTables-example" id="categoryTable">
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>status</th>
                    <th class="text-center" style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description}}</td>
                            <td>{{ $item->status}}</td>
                            <td> <a href="{{ route('product.edit', $item->id) }}" title="Edit"><i class="nav-icon fas fa-edit"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection
