@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Sales Reports</h1>
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
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                       

                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap w-100" id="dailyreports">
                                                <thead>
                                                    <tr>
                                                        <th>Product Specialist</th>
                                                        <th class="text-right">Show</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($product_specialists as $product_specialist)
                                                        <tr>
                                                            <td>{{$product_specialist->name}}</td>
                                                            <td class="text-right">
                                                                <a class="btn btn-primary btn-sm" href="{{ url('sales_report/create' , $product_specialist->id) }} "><i class="fa fa-plus"></i></a>
                                                                <a class="btn btn-success btn-sm" href="{{ route('sales_report.show' , $product_specialist->id) }} "><i class="fa fa-eye"></i></a>
                                                            </td> 
                                                                
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                
                                            </table>
                                            
                                            
                                        </div>
                                        <!-- /.card-body -->
                                        
                                    </div>
                                    <!-- /.card -->
                                    
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


@section('layouts.scripts')
    <script>
        $(document).ready(function() {
            $('#dailyreports').DataTable( {
                "scrollX": true
            } );
        } );
    </script>
@endsection