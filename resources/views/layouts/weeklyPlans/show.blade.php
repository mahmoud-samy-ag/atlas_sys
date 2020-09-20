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
                <div class="card card-primary card-outline col-12">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    {{-- <dt class="col-sm-2">D.S.M</dt>
                                    <dd class="col-sm-10">{{$district_manager->name}}</dd>
                                    <dt class="col-sm-2">AREA</dt>
                                    <dd class="col-sm-10">{{$district_manager->areas[0]->name}}</dd> --}}
                                    <dt class="col-sm-2">NAME</dt>
                                    <dd class="col-sm-10">{{$creator->name}}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6 text-md-right text-left">
                                <strong>From</strong> <span>{{$weekData->start_at}}</span> | <strong>To</strong> <span>{{$weekData->end_at}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-sm-4">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                    @foreach ($weekData->day as $index=>$day)
                                        <a class="nav-link {{$index==0 ? 'active' : ''}}" data-toggle="pill" href="#day_{{$day->day_date}}">{{ date('l', strtotime($day->day_date)) }} | {{$day->day_date}}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-7 col-sm-8">
                                <div class="tab-content" id="vert-tabs-tabContent">
                                    @foreach ($weekData->day as $index=>$day)
                                        <div class="tab-pane text-left fade {{$index==0 ? 'active show' : ''}} " id="day_{{$day->day_date}}" role="tabpanel" aria-labelledby="day_{{$day->day_date}}-tab">
                                            <dl class="row">
                                                <dt class="col-sm-5">Start Time</dt>
                                                <dd class="col-sm-7">{{$day->start_time}}</dd>
                                                <dt class="col-sm-5">Start Point</dt>
                                                <dd class="col-sm-7">{{$day->start_point}}</dd>
                                                @if (!($day->product_specialist==null))
                                                    <dt class="col-sm-5">Product Specialist</dt>
                                                    <dd class="col-sm-7">{{\App\User::where('id' , $day->product_specialist)->get()[0]->name}}</dd>
                                                @endif
                                            </dl>


                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">AM Visits</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>                  
                                                                    <tr>
                                                                        <th>Category</th>
                                                                        <th>Name</th>
                                                                        <th>Hospital Category</th>
                                                                        <th>Visiting Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($weekData->doctor as $doctor)
                                                                        @if ($doctor->day_id==$day->id)
                                                                            @php
                                                                               $customer = \App\Doctor::where(['id' => $doctor->doctor_id , 'period' => 'am'])->get()
                                                                            @endphp
                                                                            @if (empty($customer[0]))
                                                                                
                                                                            @else
                                                                                <tr>
                                                                                    <td>{{$customer[0]->category}}</td>
                                                                                    <td>{{$customer[0]->name}}</td>
                                                                                    <td>{{$customer[0]->hospital_category}}</td>
                                                                                    <td>{{$customer[0]->visiting_time}}</td>
                                                                                </tr>
                                                                            @endif
                                                                            
                                                                        @endif
                                                                        
                                                                    @endforeach
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">PM Visits</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>                  
                                                                    <tr>
                                                                        <th>Category</th>
                                                                        <th>Name</th>
                                                                        <th>Visiting Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($weekData->doctor as $doctor)
                                                                        @if ($doctor->day_id==$day->id)
                                                                            @php
                                                                               $customer = \App\Doctor::where(['id' => $doctor->doctor_id , 'period' => 'pm'])->get()
                                                                            @endphp
                                                                            @if (empty($customer[0]))
                                                                            @else
                                                                                <tr>
                                                                                    <td>{{$customer[0]->category}}</td>
                                                                                    <td>{{$customer[0]->name}}</td>
                                                                                    <td>{{$customer[0]->visiting_time}}</td>
                                                                                </tr>
                                                                            @endif
                                                                            
                                                                        @endif
                                                                        
                                                                    @endforeach
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        
                                    @endforeach


                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                      
                    </div>
                    <!-- /.card -->
                  </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

