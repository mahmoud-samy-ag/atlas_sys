@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Create Doctor</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create doctor </li>
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
                    @include('layouts.partials._errors')
                    <div class="card card-info">
                        <div class="card-header">
                          <h3 class="card- text-center">New Client</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" action="{{ route('doctors.store')}}">
                            @csrf
                            @method('post')
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Client Category</label>
                                    <div class="col-sm-10">
                                        <select name="category" class="form-control category">
                                            <option {{old('period')=='doctor' ? 'selected' : ''}} value="doctor">Clinic Doctor</option>
                                            <option {{old('period')=='hospital' ? 'selected' : ''}} value="hospital">Hospital</option>
                                            {{-- <option {{old('period')=='pharmacy' ? 'selected' : ''}} value="pharmacy">Pharmacy</option> --}}
                                        </select>
                                    </div>
                                </div>


                                <div class="for_doctor">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input value="{{old('doctor_name')}}" name="doctor_name" type="name" class="form-control" id="inputEmail3" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Specialty</label>
                                        <div class="col-sm-10">
                                            <input value="{{old('spec')}}" name="spec" type="name" class="form-control" id="inputEmail3" placeholder="Doctor Specialty">
                                        </div>
                                    </div>
                                    <div class="form-group row" style="display: none">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Class</label>
                                        <div class="col-sm-10">
                                            <select name="class" class="form-control role">
                                                <option {{old('period')=='a' ? 'selected' : ''}} value="a">A</option>
                                                <option {{old('period')=='b' ? 'selected' : ''}} value="b">B</option>
                                                <option {{old('period')=='c' ? 'selected' : ''}} value="c">C</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">KOL</label>
                                        <div class="form-check col-sm-10">
                                            <div>
                                                <input  name="kol" value="kol" type="checkbox" class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="for_hospital">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input value="{{old('hospital_name')}}" name="hospital_name" type="name" class="form-control" id="inputEmail3" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Doctor Name</label>
                                        <div class="col-sm-10">
                                            <input value="{{old('hospital_doctor')}}" name="hospital_doctor" type="name" class="form-control" id="inputEmail3" placeholder="Name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Hospital Category</label>
                                        <div class="col-sm-10">
                                            <select name="hospital_category" class="form-control">
                                                <option {{old('hospital_category')=='moh' ? 'selected' : ''}} value="moh">M.O.H.</option>
                                                <option {{old('hospital_category')=='univ' ? 'selected' : ''}} value="univ">UNIV</option>
                                                <option {{old('hospital_category')=='contract' ? 'selected' : ''}} value="contract">Contract</option>
                                                <option {{old('hospital_category')=='pr.hospital' ? 'selected' : ''}} value="pr.hospital">Pr.hospital</option>
                                                <option {{old('hospital_category')=='distributer' ? 'selected' : ''}} value="distributer">Distributer</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="for_pharmacy">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input value="{{old('pharmacist')}}" name="pharmacy_name" type="text" class="form-control" id="inputEmail3" placeholder="Name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Pharmacist Name</label>
                                        <div class="col-sm-10">
                                            <input value="{{old('pharmacist')}}" name="pharmacist" type="name" class="form-control" id="inputEmail3" placeholder="Name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Period</label>
                                        <div class="col-sm-10">
                                            <select name="period" class="form-control role">
                                                <option {{old('period')=='pm' ? 'selected' : ''}} value="pm">PM</option>
                                                <option {{old('period')=='am' ? 'selected' : ''}} value="am">AM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Visiting Time</label>
                                    <div class="col-sm-10">
                                        <input value="{{old('visiting_time')}}" name="visiting_time" type="time" class="form-control" id="inputEmail3" placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <select name="address" class="form-control role">
                                            @foreach ($addresses as $address)
                                                <option  value="{{$address->id}}">{{$address->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                
                                <button type="submit" class="btn btn-info w-100"> <i class="fas fa-plus"></i> Add</button>
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





@section('layouts.scripts')
    <script>
        function distrect_manager_users(){
            if($('.category').val()=='doctor'){
                    $('.for_doctor').show()
                    $('.for_hospital').hide()
                    $('.for_pharmacy').hide()
                }
                else if($('.category').val()=='hospital'){
                    $('.for_doctor').hide() 
                    $('.for_hospital').show()
                    $('.for_pharmacy').hide()
                }
                else if($('.category').val()=='pharmacy') {
                    $('.for_doctor').hide() 
                    $('.for_hospital').hide()
                    $('.for_pharmacy').show()
                    
                }
                else{
                    $('.for_doctor').hide() 
                    $('.for_hospital').hide()
                    $('.for_pharmacy').hide()
                }
            }
            distrect_manager_users()

            $(document).on('change' , '.category' , function(){
                distrect_manager_users()
            })
            
    </script>
@endsection
