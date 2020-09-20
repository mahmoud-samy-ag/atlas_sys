@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Areas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Areas </li>
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
                            <h3 class="card-title">areas ({{$areas->total()}}) </h3>
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
                                                    <div class="card-tools">
                                                        <a href="{{route('areas.create')}}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Create</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap w-100" id="data_table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>For</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($areas as $area)
                                                        <tr>
                                                            <td>{{$area->name}}</td>
                                                            <td>{{$area->for}}</td>
                                                            <td class="text-right">
                                                                {{-- <form action="{{ route('areas.destroy' , $area->id) }}" method="POST" class="d-inline-block">
                                                                    {{csrf_field()}}
                                                                    {{method_field('delete')}}
                                                                    <button type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                                                </form> --}}
                                                                <a class="btn btn-primary btn-sm" href="{{ route('areas.edit' , $area->id) }} "><i class="fa fa-edit"></i></a>
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
                                        {{$areas->appends(request()->query())->links()}}
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