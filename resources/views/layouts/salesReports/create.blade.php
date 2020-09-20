@extends('layouts.index')






@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            
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
                          <h3 class="card- text-center">Add Sales Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" action="{{ route('sales_report.store')}}">
                            @csrf
                            @method('post')
                            <div class="card-body">
                                

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Product Specialist</label>
                                    <div class="col-sm-10">
                                        <input value="{{$product_specialist->name}}" readonly type="text"  class="form-control">
                                        <input value="{{$product_specialist->id}}" hidden name="user_id" readonly type="text"  class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">UCP</label>
                                    <div class="col-sm-10">
                                        <input value="{{old('ucp')}}" name="ucp" type="number" min="0" class="form-control" id="inputEmail3" placeholder="UCP ...">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Direct Sales</label>
                                    <div class="col-sm-10">
                                        <input value="{{old('direct_sales')}}" name="direct_sales" type="number" min="0" class="form-control" id="inputEmail3" placeholder="Direct Sales ...">
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