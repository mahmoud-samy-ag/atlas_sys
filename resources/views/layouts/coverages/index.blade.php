@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Coverages</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Coverages </li>
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
                            <h3 class="card-title">coverages ({{$doctors->total()}}) </h3>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">

                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <form action="{{ route('coverages.index') }}" method="GET" class="input-group">
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
                                            </div>
                                        </div> 
                                        
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table id="data_table" class="table table-hover text-nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Doctor Name</th>
                                                        <th>KOL</th>
                                                        <th>Status</th>
                                                        <th class="text-right">Show</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($doctors as $doctor)
                                                        <tr>
                                                            <td>{{$doctor->category}}</td>
                                                            <td>{{$doctor->catgeory !='doctor' ? $doctor->name.' | '.$doctor->hospital_pharmacy_client : $doctor->name}}</td>
                                                            <td>{{$doctor->kol}}</td>
                                                            <td>
                                                                @if (empty(App\DailyReportDoctor::whereBetween('created_at', array($from, $to))->where('doctor_id' , $doctor->id)->get()[0]))
                                                                    <span class="text-danger">None Visited</span>
                                                                @else
                                                                    <span class="text-success">Visited</span>
                                                                @endif
                                                            </td>

                                                            <td class="text-right">
                                                                <button type="button" class="btn-sm btn btn-primary" data-toggle="modal" data-target=".doctor{{$doctor->id}}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>

                                                                <div class="modal fade doctor{{$doctor->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="card-body">
                                                                                <table class="table table-bordered text-left">
                                                                                    <thead>                  
                                                                                        <tr>
                                                                                            <th>Visiting Date</th>
                                                                                            <th>Products</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach (App\DailyReportDoctor::whereBetween('created_at', array($from, $to))->where('doctor_id' , $doctor->id)->get() as $visiting)
                                                                                            <tr>
                                                                                                <td style="vertical-align: middle;"><strong>{{$visiting->created_at}}</strong></td>
                                                                                                <td>
                                                                                                    @foreach (\App\DailyReportDoctorProduct::where('report_id' , $visiting->report_id)->get() as $product)
                                                                                                        <span>{{\App\Product::where('id' , $product->product_id)->get()[0]->name}}</span><br>
                                                                                                    @endforeach  
                                                                                                    
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                        
                                                                                    </tbody>
                                                                                </table>
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