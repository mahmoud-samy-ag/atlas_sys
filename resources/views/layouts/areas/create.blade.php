@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Create Area</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create area </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    @include('layouts.partials._errors')
                    <div class="card card-info">
                        <div class="card-header">
                          <h3 class="card- text-center">New Area</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" action="{{ route('areas.store')}}">
                            @csrf
                            @method('post')
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input value="{{old('name')}}" name="name" type="name" class="form-control" id="inputEmail3" placeholder="Area Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">For</label>
                                    <div class="col-sm-10">
                                        <select name="for" class="form-control role">
                                            <option {{old('role')=='regional_manager' ? 'selected' : ''}} value="regional_manager">Regional Manager</option>
                                            <option {{old('role')=='district_manager' ? 'selected' : ''}} value="district_manager">District Manager</option>
                                            <option {{old('role')=='product_specialist' ? 'selected' : ''}} value="product_specialist">Product Specialist</option>
                                        </select>
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