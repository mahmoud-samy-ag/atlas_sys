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
                          <h3 class="card- text-center">Update Sales Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" action="{{ route('sales_report.update' , $salesReport->id)}}">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                

                                

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">UCP</label>
                                    <div class="col-sm-10">
                                        <input value="{{$salesReport->ucp}}" name="ucp" type="number" min="0" class="form-control" id="inputEmail3" placeholder="UCP ...">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Direct Sales</label>
                                    <div class="col-sm-10">
                                        <input value="{{$salesReport->direct_sales}}" name="direct_sales" type="number" min="0" class="form-control" id="inputEmail3" placeholder="Direct Sales ...">
                                    </div>
                                </div>
                                
                
                                <button type="submit" class="btn btn-info w-100"> <i class="fas fa-save"></i> Save</button>
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