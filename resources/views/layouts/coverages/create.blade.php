@extends('layouts.index')


@section('layouts.content')

    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Create Daily Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create Daily Report </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

            

            <div class="row m-md-5">
                <form class="form-horizontal col-12 " method="post" action="{{ route('dailyReports.store')}}">
                    @csrf
                    @method('post')


                    <div class="card card-success card-outline">
                        <div class="card-header">
                          <h3 class="card-title">
                            Doctors
                          </h3>
                        </div>
                        <div class="card-body daily-report-container">
                            
                            
                        </div>
                        <div class="row">


                            <div class="col-md-4">
                                <div class="input-group input-group">
                                    <select class="form-control doctors float-right">
                                        @foreach ($doctors as $doctor)
                                        <option doctor-spec="{{$doctor->spec}}" doctor-address="{{empty($doctor->addresses[0]) ? '' : $doctor->addresses[0]->name}}" doctor-period="{{$doctor->period}}" doctor-id="{{$doctor->id}}" id= "doctor_{{$doctor->id}}">{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success add-doctor"><i class="fas fa-user-md"></i></button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="input-group input-group">
                                    <select class="form-control  float-right">
                                        @foreach ($doctors as $doctor)
                                        <option doctor-spec="{{$doctor->spec}}" doctor-address="{{empty($doctor->addresses[0]) ? '' : $doctor->addresses[0]->name}}" period="{{$doctor->period}}" doctor-id="{{$doctor->id}}" id= "doctor_{{$doctor->id}}">{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-hospital-alt"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-group input-group">
                                    <select class="form-control  float-right">
                                        @foreach ($doctors as $doctor)
                                        <option doctor-spec="{{$doctor->spec}}" doctor-address="{{empty($doctor->addresses[0]) ? '' : $doctor->addresses[0]->name}}" period="{{$doctor->period}}" doctor-id="{{$doctor->id}}" id= "doctor_{{$doctor->id}}">{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-warning"><i class="fas fa-flask"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                      </div>
                    
                    <button type="submit" class="btn btn-info w-100"> <i class="fas fa-plus"></i> Add</button>
                    
                    <!-- /.card-body -->
                 
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('layouts.scripts')
    <script>
          $(document).on('click' , '.add-doctor' , function(){

            $('.daily-report-container').append(
                '<div class="row">'
                    +'<div class="col-md-6">'
                        +'<dl class="row">'
                            +'<dt class="col-sm-4">Name</dt>'
                            +'<dd class="col-sm-8 doctor-name">'+$('.doctors').val()+'</dd>'
                            +'<dt class="col-sm-4">Speciality</dt>'
                            +'<dd class="col-sm-8 doctor-spec">'+$('.doctors').children("option:selected").attr('doctor-spec')+'</dd>'
                            +'<dt class="col-sm-4">address</dt>'
                            +'<dd class="col-sm-8 doctor-address">'+$('.doctors').children("option:selected").attr('doctor-address')+'</dd>'
                            +'<dt class="col-sm-4">Period</dt>'
                            +'<dd class="col-sm-8 doctor-period">'+$('.doctors').children("option:selected").attr('doctor-period')+'</dd>'
                        +'</dl>'
                    +'</div>'

                    +'<div class="col-md-6">'
                        +'<div class="form-group">'
                            +'<label>Commitment and Feedback</label>'
                            +'<textarea name="doctor_comm_and_feed[]" class="form-control" rows="3" placeholder="Enter ..."></textarea>'
                            +'<input type="text" name="doctor_id[]" class="form-control doctor-id" value="'+$('.doctors').children("option:selected").attr('doctor-id')+'" >'
                            +'<button class="btn btn-primary w-100" type="button" data-toggle="collapse" data-target="#'+$('.doctors').children("option:selected").attr('id')+'" aria-expanded="false" aria-controls="collapseExample"> Products </button>'
                            +'<div class="collapse" id="'+$('.doctors').children("option:selected").attr('id')+'">'
                                +'<div class="card card-body">'
                                    +'@foreach ($products as $product)'
                                        +'<div class="custom-control custom-checkbox">'
                                            +'<input name="doctor_id_'+$('.doctors').children("option:selected").attr('doctor-id')+'_product[]" value="{{$product->id}}" class="custom-control-input" type="checkbox" id="doctor_id_'+$('.doctors').children("option:selected").attr('doctor-id')+'_product{{$product->id}}">'
                                            +'<label  for="doctor_id_'+$('.doctors').children("option:selected").attr('doctor-id')+'_product{{$product->id}}" class="custom-control-label">{{$product->name}}</label>'
                                        +'</div>'
                                    +'@endforeach'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                +'</div>'
                +'<hr style="border-width:3px;border-color:#3aae55">'

                )
                $('.doctors').children("option:selected").remove()
            })
    </script>
@endsection


