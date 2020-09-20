@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Doctors</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Doctors </li>
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
                            <h3 class="card-title">doctors ({{$doctors->total()}}) </h3>
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
                                                    @if (auth()->user()->hasRole('product_specialist') || auth()->user()->hasRole('district_manager'))
                                                        <div class="card-tools">
                                                            <a href="{{route('doctors.create')}}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Create</a>
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
                                                        <th>Category</th>
                                                        <th>Name</th>
                                                        <th>Period</th>
                                                        <th>Visiting Time</th>
                                                        <th>Creator</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($doctors as $doctor)
                                                        <tr>
                                                            <td>{{$doctor->category}}</td>
                                                            <td>{{$doctor->category=='doctor' ? $doctor->name : $doctor->name.' | '.$doctor->hospital_pharmacy_client}}</td>
                                                            <td>{{$doctor->period}}</td>
                                                            <td>{{$doctor->visiting_time}}</td>
                                                            <td>{{$doctor->creators->name}}</td>
                                                            <td class="text-right">
                                                                {{-- <form action="{{ route('doctors.destroy' , $doctor->id) }}" method="POST" class="d-inline-block">
                                                                    {{csrf_field()}}
                                                                    {{method_field('delete')}}
                                                                    <button type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                                                </form> --}}
                                                                <a class="btn btn-primary btn-sm" href="{{ route('doctors.edit' , $doctor->id) }} "><i class="fa fa-edit"></i></a>
                                                                @if (!(auth()->user()->hasRole('product_specialiest')))
                                                                    @if (!($doctor->approve=='approved'))
                                                                        <a class="btn btn-warning btn-sm" href="{{ route('doctors.approve' , $doctor->id) }} ">Approve</a>
                                                                    @endif
                                                                @endif
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


