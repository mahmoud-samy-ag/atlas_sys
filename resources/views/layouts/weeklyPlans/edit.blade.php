@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Edit Day</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Day </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row m-md-5">
                <form class="form-horizontal col-12 " method="post" action="{{ route('weeklyPlans.update' , $day->id)}}">
                    @csrf
                    @method('put')



                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"  data-toggle="pill" href="#{{$day}}">{{date('l', strtotime($day->day_date)) }}</a>
                            </li>
                          </ul>
                        </div>

                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-four-tabContent">

                            <div class="tab-pane day-container fade active show" id="{{$day}}" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Day Data</label>
                                        <div class="col-sm-10">
                                            <input name="day_date" value="{{$day->day_date}}" readonly type="text" class="form-control"   placeholder="Date">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Start Time</label>
                                        <div class="col-sm-10">
                                            <input name="start_time" value="{{$day->start_time}}" type="time" class="form-control" placeholder="Start Time">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Start Point</label>
                                        <div class="col-sm-10">
                                            <input name="start_point" value="{{$day->start_point}}" type="text" class="form-control" placeholder="Start Point">
                                        </div>
                                    </div>

                                    @if (auth()->user()->hasRole('district_manager'))
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Product Specialist</label>
                                            <div class="col-sm-10">
                                                <select name="product_specialist" class="form-control doctors">
                                                    <option value="">No-one</option>
                                                    @foreach (\App\User::with('childs_id')->where('id' , auth()->user()->id)->get()[0]->childs_id as $id)
                                                        <option {{$day->product_specialist== \App\User::where('id' , $id->child_id)->get()[0]->id ? 'selected' : '' }} value="{{\App\User::where('id' , $id->child_id)->get()[0]->id }}">{{\App\User::where('id' , $id->child_id)->get()[0]->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="card card-success card-outline">
                                        <div class="card-header">
                                          <h3 class="card-title">
                                            Doctors
                                          </h3>
                                        </div>
                                        <div class="card-body doctor-info">
                                            
                                            <table class="table table-bordered">
                                                <thead>                  
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Period</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <td>
                                                        <div class="input-group input-group customer-field">
                                                            <select class="form-control doctors">
                                                                @foreach ($doctors as $doctor)
                                                                    <option doctor-address="{{empty($doctor->addresses[0]) ? '' : $doctor->addresses[0]->name}}" period="{{$doctor->period}}" doctor-id="{{$doctor->id}}" id= "doctor_{{$doctor->id}}">{{$doctor->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-success add-doctor"><i class="fas fa-user-md"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group customer-field">
                                                            <select class="form-control doctors">
                                                                @foreach ($hospitals as $hospital)
                                                                    <option doctor-address="{{empty($hospital->addresses[0]) ? '' : $hospital->addresses[0]->name}}" period="{{$hospital->period}}" doctor-id="{{$hospital->id}}" id= "doctor_{{$hospital->id}}">{{$hospital->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-primary add-doctor"><i class="fas fa-hospital-alt"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group customer-field">
                                                            <select class="form-control doctors">
                                                                @foreach ($pharmacies as $pharmacy)
                                                                    <option doctor-address="{{empty($pharmacy->addresses[0]) ? '' : $pharmacy->addresses[0]->name}}" period="{{$pharmacy->period}}" doctor-id="{{$pharmacy->id}}" id= "doctor_{{$pharmacy->id}}">{{$pharmacy->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-warning add-doctor"><i class="fas fa-flask"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tfoot>
                                            </table>
                                            
                                        </div>
                                        
                                        
                                        
                                        <!-- /.card -->
                                      </div>
                                </div> 
                            </div>
                          </div>
                        </div>

                        
                        <!-- /.card -->
                      </div>
                      <button type="submit" class="btn btn-info w-100"> <i class="fas fa-save"></i> Save</button>
                    
                    <!-- /.card-body -->
                 
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection


@section('layouts.scripts')
    <script>
          function add_weekly_plan_doctor(){

                $(document).on('click' , '.add-doctor' , function(){
                



                    var day=$(this).closest('.day-container').attr('id')

                    $(this).closest('.day-container').find('.doctor-info table tbody').append(

                        '<tr>'
                            +'<td>'+$(this).closest('.customer-field').find('.doctors').val()+'</td>'
                            +'<td>'+$(this).closest('.customer-field').find('.doctors').children("option:selected").attr('doctor-address')+'</td>'
                            +'<td>'
                                +$(this).closest('.customer-field').find('.doctors').children("option:selected").attr('period')
                                +'<input hidden name="doctor_id[]" type="text" class="form-control" placeholder="Doctor Name" value="'+$(this).closest('.customer-field').find('.doctors').children("option:selected").attr('doctor-id')+'">'
                            +'</td>'
                        +'</tr>'
                    )
                    $(this).closest('.customer-field').find('.doctors').children("option:selected").remove()

                })


            }

            add_weekly_plan_doctor()

    </script>
@endsection