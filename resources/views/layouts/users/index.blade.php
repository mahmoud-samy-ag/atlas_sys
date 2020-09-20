@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Users </li>
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
                            <h3 class="card-title">Users ({{$users->total()}}) </h3>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('layouts.partials._errors')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-10"></div>
                                                <div class="col-md-2">
                                                    @if (auth()->user()->hasRole('ceo') || auth()->user()->hasRole('general_manager'))
                                                        <div class="card-tools">
                                                            <a href="{{route('users.create')}}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Create</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap w-100" id="users">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Job Title</th>
                                                        <th>Action</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $user)
                                                        <tr>
                                                            <td>{{$user->name}}</td>
                                                            <td>{{$user->email}}</td>
                                                            <td>{{$user->job_title}}</td>
                                                            <td class="text-right">
                                                                @if (auth()->user()->hasRole('ceo') || auth()->user()->hasRole('general_manager'))
                                                                
                                                                    {{-- <form action="{{ route('users.destroy' , $user->id) }}" method="POST" class="d-inline-block">
                                                                        {{csrf_field()}}
                                                                        {{method_field('delete')}}
                                                                        <button type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                                                    </form> --}}
                                                                    <a class="btn btn-primary btn-sm" href="{{ route('users.edit' , $user->id) }} "><i class="fa fa-edit"></i></a>
                                                                @endif

                                                                @if ($user->hasRole('product_specialist') || $user->hasRole('district_manager'))
                                                                    @if ($user->allow_plan=='yes')
                                                                        <a class="btn btn-dark btn-sm" href="{{ route('users.disable_plan' , $user->id) }} "> Disable Plan</a> 
                                                                    @else
                                                                        <a class="btn btn-warning btn-sm" href="{{ route('users.allow_plan' , $user->id) }} "> Allow Plan</a>
                                                                    @endif
                                                                @endif
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
                                        {{$users->appends(request()->query())->links()}}
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

@section('layouts.scripts')
    <script>
        $(document).ready(function() {
            $('#users').DataTable( {
                "scrollX": true
            } );
        } );
    </script>
@endsection