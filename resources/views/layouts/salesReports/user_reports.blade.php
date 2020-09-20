@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Reports</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Reports </li>
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
                            <h3 class="card-title">Reports ({{$reports->total()}}) </h3>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                        
                                            <div class="row">
                                                
                                                <div class="col-md-8">
                                                    <form action="{{ route('sales_report.show' , $user_id) }}" method="GET" class="input-group">
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
                                                
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap w-100" id="reports">
                                                <thead>
                                                    <tr>
                                                        <th>UCP</th>
                                                        <th>Direct Sales</th>
                                                        <th>Total</th>
                                                        <th>Date</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($reports as $report)
                                                        <tr>
                                                            <td>{{$report->ucp}}</td>
                                                            <td>{{$report->direct_sales}}</td>
                                                            <td>{{$report->ucp + $report->direct_sales}}</td>
                                                            <td>{{$report->created_at}}</td>

                                                            <td class="text-right">


                                                                @if (auth()->user()->hasRole('product_specialist'))
                                                                    <form action="{{ route('sales_report.destroy' , $report->id) }}" method="POST" class="d-inline-block">
                                                                        {{csrf_field()}}
                                                                        {{method_field('delete')}}
                                                                        <button type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                                                    </form>
                                                                @endif


                                                                
                                                                <a class="btn btn-primary btn-sm" href="{{ route('sales_report.edit' , $report->id) }} "><i class="fa fa-edit"></i></a>
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
                                        {{$reports->appends(request()->query())->links()}}
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


@section('layouts.scripts')
    <script>
        $(document).ready(function() {
            $('#reports').DataTable( {
                "scrollX": true
            } );
        } );
    </script>
@endsection