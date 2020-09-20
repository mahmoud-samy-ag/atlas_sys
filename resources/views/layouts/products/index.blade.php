@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Product </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">products ({{$products->total()}}) </h3>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                        
                                            <div class="row">
                                                <div class="col-md-10"></div>
                                                <div class="col-md-2">
                                                    @if (auth()->user()->hasRole('ceo') || auth()->user()->hasRole('general_manager'))
                                                        <div class="card-tools">
                                                            <a href="{{route('products.create')}}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Create</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap w-100" id="data_table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>{{$product->name}}</td>
                                                            
                                                            <td class="text-right">
                                                                {{-- <form action="{{ route('products.destroy' , $product->id) }}" method="POST" class="d-inline-block">
                                                                    {{csrf_field()}}
                                                                    {{method_field('delete')}}
                                                                    <button type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                                                </form> --}}
                                                                <a class="btn btn-primary btn-sm" href="{{ route('products.edit' , $product->id) }} "><i class="fa fa-edit"></i></a>
                                                            </td> 
                                                                
                                                                
                                                            
                                                            
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                
                                            </table>
                                            
                                            
                                        </div>
                                        <!-- /.card-body -->
                                        
                                    </div>
                                    <!-- /.card -->
                                    <div class="text-right">
                                        {{$products->appends(request()->query())->links()}}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection