@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Edite Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Edite user </li>
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
                          <h3 class="card- text-center">Edit User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" action="{{ route('users.update' , $user->id)}}">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-10">
                                        <input value="{{$user->name}}" name="name" type="name" class="form-control" id="inputEmail3" placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input value="{{$user->email}}" name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email">
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Role</label>
                                    <div class="col-sm-10">
                                        <select name="role" class="form-control role">
                                            @if (auth()->user()->hasRole('ceo'))<option {{$user->hasRole('ceo') ? 'selected' : ''}} value="ceo">CEO</option>@endif
                                            <option {{$user->hasRole('general_manager') ? 'selected' : ''}} value="general_manager">General Manager</option>
                                            <option {{$user->hasRole('regional_manager') ? 'selected' : ''}} value="regional_manager">Regional Manager</option>
                                            <option {{$user->hasRole('district_manager') ? 'selected' : ''}} value="district_manager">District Manager</option>
                                            <option {{$user->hasRole('product_specialist') ? 'selected' : ''}} value="product_specialist">Product Specialist</option>
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
                                                @if (in_array($product_specialist->id, $user_child_id))
                                                    <div>
                                                        <input checked  name="product_specialist[]" value="{{$product_specialist->id}}" type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="form-check-label" for="exampleCheck1">{{$product_specialist->name}}</label>
                                                    </div>
                                                    @else
                                                        @if (in_array($product_specialist->id, $all_child_id))
                                                        @else
                                                            @if (!($product_specialist->id==$user->id))
                                                                <div>
                                                                    <input name="product_specialist[]" value="{{$product_specialist->id}}" type="checkbox" class="form-check-input" id="exampleCheck1">
                                                                    <label class="form-check-label" for="exampleCheck1">{{$product_specialist->name}}</label>
                                                                </div> 
                                                            @endif
                                                            
                                                        @endif
                                                @endif
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
                                                @if (in_array($district_manager->id, $user_child_id))
                                                    <div>
                                                        <input checked  name="district_managers_for_regional_manager[]" value="{{$district_manager->id}}" type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="form-check-label" for="exampleCheck1">{{$district_manager->name}}</label>
                                                    </div>
                                                    @else
                                                        @if (in_array($district_manager->id, $all_child_id))
                                                        @else
                                                            @if (!($district_manager->id==$user->id))
                                                                <div>
                                                                    <input name="district_managers_for_regional_manager[]" value="{{$district_manager->id}}" type="checkbox" class="form-check-input" id="exampleCheck1">
                                                                    <label class="form-check-label" for="exampleCheck1">{{$district_manager->name}}</label>
                                                                </div> 
                                                            @endif
                                                            
                                                        @endif
                                                @endif
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
                                                @if (!(empty($parent_id_for_child_id[0])))
                                                    <option {{$parent_id_for_child_id[0]->parent_id==$district_manager->id ? 'selected' : ''}}  value="{{$district_manager->id}}">{{$district_manager->name}}</option>
                                                @else
                                                    <option  value="{{$district_manager->id}}">{{$district_manager->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group for_product_specialist row" style="display: none">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Job Title</label>
                                    <div class="col-sm-10">
                                        <select name="job_title" class="form-control role">
                                            <option {{$user->job_title=='Product Specialist' ? 'selected' : ''}} value="Product Specialist">Product Specialist</option>
                                            <option {{$user->job_title=='Senior Product Specialist' ? 'selected' : ''}} value="Senior Product Specialist">Senior Product Specialist</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group for_district_manager row" style="display: none">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Regional Managers</label>
                                    <div class="col-sm-10">
                                        <select name="regional_manager" class="form-control role">
                                            <option></option>
                                            
                                            @foreach ($regional_managers as $regional_manager)
                                                @if (!(empty($parent_id_for_child_id[0])))
                                                    <option {{$parent_id_for_child_id[0]->parent_id==$regional_manager->id ? 'selected' : ''}}  value="{{$regional_manager->id}}">{{$regional_manager->name}}</option>
                                                @else
                                                    @if (!($regional_manager->id==$user->id))
                                                        <option  value="{{$regional_manager->id}}">{{$regional_manager->name}}</option>
                                                    @endif
                                                    
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                
                                <div class="form-group row areas">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Area</label>
                                    <div class="col-sm-10 area_select">
                                        
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label"><a href="{{route('users.reset_password' , $user->id)}}" target="_blank">Reset password</a></label>
                                    
                                </div>
                                
                                <button type="submit" class="btn btn-info w-100"> <i class="fas fa-save"></i> Save</button>
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


            if($('.role').val()=='ceo'){
                $('.areas').hide()
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
                            +'@if (empty($area->user_id[0]))'
                                +'<option  value="{{$area->id}}">{{$area->name}}</option>'
                            +'@else'
                                +'@if ($area->user_id[0]->user_id == $user->id)'
                                    +'<option selected  value="{{$area->id}}">{{$area->name}}</option>'
                                +'@endif'
                            +'@endif'
                        +'@endforeach'
                    +'</select>'
                )

               
            }
            else if($('.role').val()=='product_specialist'){
                $('.for_product_specialist').show()
                $('.for_district_manager').hide()
                $('.for_regional_manager').hide()
                $('.area_select').html(
                    '<select name="area" class="form-control">'
                        +' <option></option>'
                        +'@foreach ($areas["product_specialist"] as $area)'
                            +'@if (empty($area->user_id[0]))'
                                +'<option  value="{{$area->id}}">{{$area->name}}</option>'
                            +'@else'
                                +'@if ($area->user_id[0]->user_id == $user->id)'
                                    +'<option selected  value="{{$area->id}}">{{$area->name}}</option>'
                                +'@endif'
                            +'@endif'
                        +'@endforeach'
                    +'</select>'
                )
                
            }
            else if($('.role').val()=='regional_manager'){
                $('.for_product_specialist').show()
                $('.for_district_manager').hide()
                $('.for_regional_manager').show()

                $('.area_select').html(
                    '<select name="area" class="form-control">'
                        +'<option></option>'
                            +'@foreach ($areas["regional_manager"] as $area)'
                                +'@if (empty($area->user_id[0]))'
                                    +'<option  value="{{$area->id}}">{{$area->name}}</option>'
                                +'@else'
                                    +'@if ($area->user_id[0]->user_id == $user->id)'
                                        +'<option selected  value="{{$area->id}}">{{$area->name}}</option>'
                                    +'@endif'
                                +'@endif'
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

