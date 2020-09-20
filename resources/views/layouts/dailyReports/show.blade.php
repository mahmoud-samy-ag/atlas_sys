@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Daily Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('dailyReports.index')}}">Daily Reports</a></li>
                            <li class="breadcrumb-item active">Show</li>
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
                            <h3 class="card-title">Customers ({{$doctors->total()}}) </h3>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Real Address</th>
                                                        <th class="text-right">Product</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($doctors as $doctor)
                                                        <tr>
                                                            <td>
                                                                {{\App\Doctor::where('id' , $doctor->doctor_id)->get()[0]->category}}
                                                            </td>
                                                            <td>
                                                                {{\App\Doctor::where('id' , $doctor->doctor_id)->get()[0]->name}}
                                                            </td>
                                                            
                                                            <td>
                                                                {{\App\Address::where('id' , \App\AddressDoctor::where('doctor_id' , $doctor->doctor_id)->get()[0]->address_id)->get()[0]->name}}
                                                            </td>
                                                            <td>
                                                                <a href="https://www.google.com/maps/search/?api=1&query={{$doctor->latitude}},{{$doctor->longitude}}">show</a>
                                                            </td>
                                                            <td class="text-right">

                                                                <button type="button" class="btn-sm btn btn-primary" data-toggle="modal" data-target=".doctor{{$doctor->doctor_id}}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>

                                                                <div class="modal fade doctor{{$doctor->doctor_id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="card-body">
                                                                                <dl class="row text-left">
                                                                                    
                                                                                    @foreach (\App\DailyReportDoctorProduct::where(['doctor_id' => $doctor->doctor_id , 'report_id' => $doctor->report_id])->get() as $product)
                                                                                        <dt class="col-sm-4">{{\App\Product::where('id' , $product->product_id)->get()[0]->name}}</dt>
                                                                                        <dd class="col-sm-8">{{$product->feedback}}</dd>
                                                                                    @endforeach
                                                                                </dl>
                                                                                
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