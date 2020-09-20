@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Create Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create user </li>
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
                          <h3 class="card- text-center">New User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" action="{{ route('users.store')}}">
                            @csrf
                            @method('post')
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-10">
                                        <input value="{{old('name')}}" name="name" type="name" class="form-control" id="inputEmail3" placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input value="{{old('email')}}" name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password Confirmation</label>
                                    <div class="col-sm-10">
                                        <input name="password_confirmation" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Role</label>
                                    <div class="col-sm-10">
                                        <select name="role" class="form-control role">
                                            @if (auth()->user()->hasRole('ceo'))<option {{old('role')=='ceo' ? 'selected' : ''}} value="ceo">CEO</option>@endif
                                            <option {{old('role')=='general_manager' ? 'selected' : ''}} value="general_manager">General Manager</option>
                                            <option {{old('role')=='regional_manager' ? 'selected' : ''}} value="regional_manager">Regional Manager</option>
                                            <option {{old('role')=='district_manager' ? 'selected' : ''}} value="district_manager">District Manager</option>
                                            <option {{old('role')=='product_specialist' ? 'selected' : ''}} value="product_specialist">Product Specialist</option>
                                        </select>
                                    </div>
                                </div>
                            

                                <div class="form-group row for_district_manager" style="display: none">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Product Specialist</label>
                                    <div class="form-check col-sm-10">
                                        @if (empty($product_specialists[0]))
                                            <p><strong class="text-danger">No Product Specialist To Select</strong></p>
                                        @else
                                            @foreach ($product_specialists as $product_specialist)
                                                <div>
                                                    <input  name="product_specialist[]" value="{{$product_specialist->id}}" type="checkbox" class="form-check-input" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">{{$product_specialist->name}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row for_regional_manager" style="display: none">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">District Manager</label>
                                    <div class="form-check col-sm-10">
                                        @if (empty($district_managers['for_regional_manager'][0]))
                                            <p><strong class="text-danger">No District Manager To Select</strong></p>
                                        @else
                                            @foreach ($district_managers['for_regional_manager'] as $district_manager)
                                                <div>
                                                    <input  name="district_managers_for_regional_manager[]" value="{{$district_manager->id}}" type="checkbox" class="form-check-input" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">{{$district_manager->name}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                



                                <div class="form-group for_product_specialist row" style="display: none">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">District Manager</label>
                                    <div class="col-sm-10">
                                        <select name="district_manager" class="form-control role">
                                            <option></option>
                                            @foreach ($district_managers['for_product_specialist'] as $district_manager)
                                                <option value="{{$district_manager->id}}">{{$district_manager->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group for_district_manager row" style="display: none">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Regional Manager</label>
                                    <div class="col-sm-10">
                                        <select name="regional_manager" class="form-control role">
                                            <option></option>
                                            @foreach ($regional_managers as $regional_manager)
                                                <option value="{{$regional_manager->id}}">{{$regional_manager->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group for_product_specialist row" style="display: none">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Job Title</label>
                                    <div class="col-sm-10">
                                        <select name="job_title" class="form-control role">
                                            <option value="Product Specialist">Product Specialist</option>
                                            <option value="Senior Product Specialist">Senior Product Specialist</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row areas">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Area</label>
                                    <div class="col-sm-10 area_select">
                                        
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


            if($('.role').val()=='ceo' || $('.role').val()=='general_manager'){
                $('.areas').hide()
                $('.for_district_manager').hide() 
                $('.for_product_specialist').hide()
                $('.for_regional_manager').hide()
            }else{
                $('.areas').show()
            }

                
            

            if($('.role').val()=='district_manager'){
                $('.for_district_manager').show()
                $('.for_product_specialist').hide()
                $('.for_regional_manager').hide()
                $('.area_select').html(
                    '<select name="area[]" multiple class="form-control">'
                        +' <option></option>'
                        +'@foreach ($areas["district_manager"] as $area)'
                            +'<option  value="{{$area->id}}">{{$area->name}}</option>'
                        +'@endforeach'                   
                    +'</select>'
                )

               
            }
            else if($('.role').val()=='product_specialist'){
                $('.for_product_specialist').show()
                $('.for_district_manager').hide()
                $('.for_regional_manager').hide()
                $('.area_select').removeAttr('multiple')
                $('.area_select').html(
                    '<select name="area" class="form-control">'
                        +' <option></option>'
                        +'@foreach ($areas["product_specialist"] as $area)'
                            +'<option  value="{{$area->id}}">{{$area->name}}</option>'
                        +'@endforeach'
                    +'</select>'
                )
                
            }
            else if($('.role').val()=='regional_manager'){
                $('.for_product_specialist').show()
                $('.for_district_manager').hide()
                $('.for_regional_manager').show()
                $('.area_select').removeAttr('multiple')
                $('.area_select').html(
                    '<select name="area" class="form-control">'
                        +' <option></option>'
                        +'@foreach ($areas["regional_manager"] as $area)'
                            +'<option  value="{{$area->id}}">{{$area->name}}</option>'
                        +'@endforeach'
                    +'</select>'
                )

                $('.for_district_manager').hide() 
                $('.for_product_specialist').hide()
            }
            else{
                $('.for_district_manager').hide() 
                $('.for_product_specialist').hide()
                
            }

        }
            distrect_manager_users()
            $(document).on('change' , '.role' , function(){
                distrect_manager_users()
            })
    </script>
@endsection

