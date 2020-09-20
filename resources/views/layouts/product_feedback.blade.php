@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Product Feedback</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Product Feedback</li>
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
                    <div class="card">
                    
                        <!-- /.card-header -->
                        <div class="accordion" id="accordionExample">
                            @foreach ($doctors as $doctor)
                                
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                      <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#doctor{{$doctor->id}}" aria-expanded="true" aria-controls="collapseOne">
                                            {{$doctor->category == 'doctor' ? $doctor->name : $doctor->hospital_pharmacy_client.' | '.$doctor->name}}
                                        </button>
                                      </h2>
                                    </div>
                                
                                    <div id="doctor{{$doctor->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                       <div class="card">
                                           <div class="card-body">
                                            @foreach ($doctor->product_feedback as $index=>$product_feedback)
                                                <p>{{$product_feedback->feedback}}</p>
                                                <hr>
                                            @endforeach
                                           </div>
                                       </div>
                                    </div>
                                  </div>
                            @endforeach
                            
                            
                          </div>
                        
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection