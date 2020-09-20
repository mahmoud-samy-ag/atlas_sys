@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Market Feedback</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Market Feedbacks </li>
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
                            <h3 class="card-title">market feedbacks ({{$marketFeedbacks->total()}}) </h3>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('layouts.partials._errors')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                        
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <form action="{{ route('marketFeedbacks.index') }}" method="GET" class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                From
                                                            </span>
                                                        </div>
                                                        <input name="from" type="date" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                To
                                                            </span>
                                                        </div>
                                                        <input name="to" type="date" class="form-control">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success">
                                                                Go
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-1"></div>
                                                {{-- <div class="col-md-4">
                                                    @if (auth()->user()->hasRole('product_specialist'))
                                                        <div class="card-tools">
                                                            <a href="{{route('marketFeedbacks.create')}}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Create</a>
                                                        </div>
                                                    @endif
                                                    
                                                </div> --}}
                                            </div>
                                        </div>

                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap w-100" id="data_table">
                                                <thead>
                                                    <tr>
                                                        <th>Creator</th>
                                                        <th>Customer</th>
                                                        <th>Address</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($marketFeedbacks as $marketFeedback)
                                                        <tr>
                                                            <td>{{\App\User::where('id' , auth()->user()->id)->get()[0]->name}}</td>
                                                            <td>{{\App\Doctor::where('id' , $marketFeedback->doctor_id)->get()[0]->name}}</td>
                                                            <td>{{\App\Address::where('id' , \App\AddressDoctor::where('doctor_id' , $marketFeedback->doctor_id)->get()[0]->address_id)->get()[0]->name}}</td>
                                                            <td class="text-right">

                                                                @if (auth()->user()->hasRole('product_specialist'))
                                                                    <form action="{{ route('marketFeedbacks.destroy' , $marketFeedback->id) }}" method="POST" class="d-inline-block">
                                                                        {{csrf_field()}}
                                                                        {{method_field('delete')}}
                                                                        <button type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                                                    </form>
                                                                @endif
                                                                
                                                                {{-- <a class="btn btn-primary btn-sm" href="{{ route('marketFeedback.edit' , $marketFeedback->id) }} "><i class="fa fa-edit"></i></a> --}}
                                                                <a class="btn btn-success btn-sm" href="{{ route('marketFeedbacks.show' , $marketFeedback->id) }} "><i class="fa fa-eye"></i></a>
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
                                        {{$marketFeedbacks->appends(request()->query())->links()}}
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

