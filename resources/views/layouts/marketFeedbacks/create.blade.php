@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Create Market Feedback</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create Market Feedback </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row m-5">
                <div class="col-12">
                    @include('layouts.partials._errors')
                    <div class="card card-info">
                        <div class="card-header">
                          <h3 class="card- text-center">New Market Feedback</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" action="{{ route('marketFeedbacks.store')}}">
                            @csrf
                            @method('post')
                            <div class="card-body">

                                <div class="row">
                        
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-12 col-form-label">Customer</label>
                                            <div class="col-sm-12">
                                                <select name="doctor_id" class="form-control role">
                                                    @foreach ($doctors as $doctor)
                                                        <option {{old('doctor')==$doctor->id ? 'selected' : ''}} value="{{$doctor->id}}">{{$doctor->name}}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-12 col-form-label">Promotional Visits</label>
                                            <div class="col-sm-12">
                                                <select value="{{old('feedback_type')}}" name="feedback_type[]" multiple="" class="form-control">
                                                    <option>Meeting, Symposium, Club meeting, etc…</option>
                                                    <option>Activities</option>
                                                    <option>Brochure</option>
                                                    <option>Promo materials  (Giveaways …… etc)</option>
                                                    <option>Team Expansion</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-12 col-form-label">Pharmacy1</label>
                                            <div class="col-sm-12">
                                                <textarea rows="2" value="{{old('pharmacy1')}}" name="pharmacy1"class="form-control"  placeholder="feedback details ... "></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-12 col-form-label">Pharmacy2</label>
                                            <div class="col-sm-12">
                                                <textarea rows="2" value="{{old('pharmacy2')}}" name="pharmacy2"class="form-control"  placeholder="feedback details ... "></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-12 col-form-label">Pharmacy3</label>
                                            <div class="col-sm-12">
                                                <textarea rows="2" value="{{old('pharmacy3')}}" name="pharmacy3"class="form-control"  placeholder="feedback details ... "></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Products</label>
                                        @foreach ($products as $product)
                                            <div class="custom-control custom-checkbox">
                                                <input name="products[]" value="{{$product->id}}" class="custom-control-input" type="checkbox" id="product{{$product->id}}">
                                                <label for="product{{$product->id}}" class="custom-control-label">{{$product->name}}</label>
                                            </div>
                                        @endforeach

                                        
                                        
                                    </div>
                                </div>


                                
                                <button type="submit" class="btn btn-info w-100"> <i class="fas fa-plus"></i> Add</button>
                            </div>
                            
                            <!-- /.card-body -->
                         
                        </form>
                    </div>
                    
                </div>
                <div class="col-md-1"></div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection