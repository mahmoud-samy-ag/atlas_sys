@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Create Weekly Plan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create weeklyplan </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row m-md-5">
                <form class="form-horizontal col-12 " method="post" action="{{ route('weeklyPlans.store')}}">
                    @csrf
                    @method('post')



                    @php
                        $days=['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday']
                    @endphp




                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">

                            @foreach ($days as $index=>$day)
                                <li class="nav-item">
                                    <a class="nav-link {{$index==0 ? 'active' : ''}}"  data-toggle="pill" href="#{{$day}}">{{$day}}</a>
                                </li>
                            @endforeach

                              
                              
                              
                          </ul>
                        </div>

                        


                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-four-tabContent">

                            @foreach ($days as $index=>$day)

                                <div class="tab-pane day-container fade {{$index==0 ? 'active show' : ''}}" id="{{$day}}" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Day Data</label>
                                            <div class="col-sm-10">
                                                <input name="day_date[]" value="{{$weekDays[$day]}}" readonly type="text" class="form-control day_date"  placeholder="Date">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Start Time</label>
                                            <div class="col-sm-10">
                                                <input name="start_time[]" type="time" class="form-control start_time" placeholder="Start Time">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Start Point</label>
                                            <div class="col-sm-10">
                                                <input name="start_point[]" type="text" class="form-control start_point" placeholder="Start Point">
                                            </div>
                                        </div>

                                        @if (auth()->user()->hasRole('district_manager'))
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Product Specialist</label>
                                                <div class="col-sm-10">
                                                    <select name="product_specialist[]" class="form-control product_specialist">
                                                        <option value="">No-one</option>
                                                        @foreach ($product_specialists as $data)
                                                            <option value="{{$data->user_id}}" weekly_plan_id="{{$data->weekly_plan_id}}">{{$data->name}}</option>
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
                                                       
                                                    </tfoot>
                                                </table>

                                                <div class="row mt-5">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group customer-field">
                                                            <select class="form-control doctors">
                                                                @foreach ($hospitals as $hospital)
                                                                    <option doctor-address="{{empty($hospital->addresses[0]) ? '' : $hospital->addresses[0]->name}}" period="{{$hospital->period}}" doctor-id="{{$hospital->id}}" id= "doctor_{{$hospital->id}}">{{$hospital->name}} | {{$hospital->hospital_pharmacy_client}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-primary add-doctor"><i class="fas fa-hospital-alt"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
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
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            
                                            
                                            <!-- /.card -->
                                          </div>
                                    </div> 
                                </div>
                            @endforeach
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



        $('.product_specialist').change(function(){
            $(this).closest('.day-container').find('.doctor-info table tbody').html('')
            var product_specialist_id=$(this).val()
            var weekly_plan_id=$(this).children("option:selected").attr('weekly_plan_id')
            var day_date =$(this).closest('.card-body').find('.day_date').val()
            var data = @json($product_specilaist_day) 
            var day=$(this).closest('.day-container').attr('id')
            data.forEach(element => duble_visits(element , $(this)));
            
            function duble_visits(element , current_element){
                // console.log(element )
                if(day_date==element.day_date){
                    if(product_specialist_id==element.user_id){
                        if(weekly_plan_id == element.weekly_plan_id){
                            current_element.closest('.card-body').find('.start_point').val(element.start_point)
                            current_element.closest('.card-body').find('.start_time').val(element.start_time)

                            if(element.doctor_category=='doctor'){
                                current_element.closest('.day-container').find('.doctor-info table').append(

                                    '<tr>'
                                        +'<td>'+element.doctor_name+'</td>'
                                        +'<td>-</td>'
                                        +'<td>'
                                            +element.period
                                            +'<input hidden name="'+day+'_doctor_id[]" type="text" class="form-control" placeholder="Doctor Name" value="'+element.doctor_id+'">'
                                        +'</td>'
                                    +'</tr>'
                                )
                            }else{
                                current_element.closest('.day-container').find('.doctor-info table').append(
                                '<tr>'
                                    +'<td>'+element.doctor_name+' | '+element.hospital_pharmacy_client+'</td>'
                                    +'<td>-</td>'
                                    +'<td>'
                                        +element.period
                                        +'<input hidden name="'+day+'_doctor_id[]" type="text" class="form-control" placeholder="Doctor Name" value="'+element.doctor_id+'">'
                                    +'</td>'
                                +'</tr>'
                            )
                            }
                            


                            console.log(element)

                        }
                    }
                }
                
                
            }
           


        })



          function add_weekly_plan_doctor(){

                $(document).on('click' , '.add-doctor' , function(){
                



                    var day=$(this).closest('.day-container').attr('id')

                    $(this).closest('.day-container').find('.doctor-info table tbody').append(

                        '<tr>'
                            +'<td>'+$(this).closest('.customer-field').find('.doctors').val()+'</td>'
                            +'<td>'+$(this).closest('.customer-field').find('.doctors').children("option:selected").attr('doctor-address')+'</td>'
                            +'<td>'
                                +$(this).closest('.customer-field').find('.doctors').children("option:selected").attr('period')
                                +'<input hidden name="'+day+'_doctor_id[]" type="text" class="form-control" placeholder="Doctor Name" value="'+$(this).closest('.customer-field').find('.doctors').children("option:selected").attr('doctor-id')+'">'
                            +'</td>'
                        +'</tr>'
                    )
                    $(this).closest('.customer-field').find('.doctors').children("option:selected").remove()

                })


            }

            add_weekly_plan_doctor()

    </script>
@endsection