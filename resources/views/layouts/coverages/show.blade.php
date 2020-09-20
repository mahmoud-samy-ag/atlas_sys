@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Daily Reports</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Daily Reports </li>
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
                            <h3 class="card-title">dailyReports ({{$doctors->total()}}) </h3>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                        
                                        <div class="card-tools">
                                            <form class="input-group input-group" action="{{ route('dailyReports.show' , $dailyReport->id) }}" method="get">
                                                <div class="input-group-prepend">
                                                    <a href="{{route('dailyReports.create')}}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                                                </div>
                                                <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{request()->search}}">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Doctor / Pharm</th>
                                                        <th>Address</th>
                                                        <th>Product</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($doctors as $doctor)
                                                        <tr>
                                                            <td>test</td>
                                                            <td>
                                                                {{\App\Doctor::where('id' , $doctor->doctor_id)->get()[0]->name}}
                                                            </td>
                                                            <td>
                                                                {{\App\Address::where('id' , \App\AddressDoctor::where('doctor_id' , $doctor->doctor_id)->get()[0]->location_id)->get()[0]->name}}
                                                            </td>
                                                            <td>

                                                                <button type="button" class="btn-sm btn btn-primary" data-toggle="modal" data-target=".doctor{{$doctor->doctor_id}}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>

                                                                <div class="modal fade doctor{{$doctor->doctor_id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-sm" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="card-body">
                                                                                <ul>
                                                                                    @foreach ($doctor->product_ids as $product)
                                                                                        <li>{{ \App\Product::where('id' , $product->product_id)->get()[0]->name}}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>

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
                                        {{$doctors->appends(request()->query())->links()}}
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