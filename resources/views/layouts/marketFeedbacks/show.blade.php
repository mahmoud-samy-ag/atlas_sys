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
                            <li class="breadcrumb-item active">Market Feedback </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row m-md-5">
                <div class="card card-primary card-outline col-12">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Doc Name</dt>
                                    <dd class="col-sm-8">{{$doctor->name}}</dd>
                                    <dt class="col-sm-4">Doc Address</dt>
                                    <dd class="col-sm-8">{{$doctor->addresses[0]->name}}</dd>
                                    <dt class="col-sm-4">Area</dt>
                                   
                                    <dd class="col-sm-8">{{$feedbackData->created_at}}</dd>
                                    <dt class="col-sm-4">M.R Name</dt>
                                    <dd class="col-sm-8">Test</dd>
                                    <dt class="col-sm-4">D.M</dt>
                                    <dd class="col-sm-8">{{$district_manager->name}}</dd>
                                    <dt class="col-sm-4">Product Manager</dt>
                                    <dd class="col-sm-8">{{$creator->name}}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    @foreach ($products as  $index=>$product)
                                        <dt class="col-sm-4">Product {{$index+1}}</dt>
                                        <dd class="col-sm-8">{{\App\Product::where('id' , $product)->get()[0]->name}}</dd>
                                    @endforeach
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Promotional Visits</dt>
                                    @foreach ($feedbackType as $index=>$value)
                                        <dd class="col-sm-8 {{$index==0 ? '' : 'offset-sm-4'}}">{{$value}}</dd>
                                    @endforeach
                                    
                                </dl>
                            </div>
                            
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <dl class="row">
                                    <dt class="col-sm-4">Pharmacy1</dt>
                                    <dd class="col-sm-8">{{$feedbackData->pharmacy1}}</dd>
                                    <dt class="col-sm-4">Pharmacy2</dt>
                                    <dd class="col-sm-8">{{$feedbackData->pharmacy2}}</dd>
                                    <dt class="col-sm-4">Pharmacy3</dt>
                                    <dd class="col-sm-8">{{$feedbackData->pharmacy3}}</dd>
                                    
                                </dl>
                            </div>
                        </div>
                      
                    </div>
                    <!-- /.card -->
                  </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

