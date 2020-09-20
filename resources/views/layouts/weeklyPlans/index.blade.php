@extends('layouts.index')


@section('layouts.content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Weekly Plan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Weekly Plans </li>
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
                            <h3 class="card-title">weekly plans ({{$weeklyPlans->total()}}) </h3>
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
                                                <div class="col-md-7">
                                                    <form action="{{ route('weeklyPlans.index') }}" method="GET" class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                From
                                                            </span>
                                                        </div>
                                                        <input name="from" type="date" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                To
                                                            </span>
                                                        </div>
                                                        <input name="to" type="date" class="form-control">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success">
                                                                Go
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-4">
                                                    @if (auth()->user()->hasRole('product_specialist')  || auth()->user()->hasRole('district_manager'))
                                                        @if ($plan_checker)
                                                            <div class="card-tools">
                                                                <a href="{{route('weeklyPlans.create')}}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Create</a>
                                                            </div>
                                                        @else

                                                            @if (auth()->user()->allow_plan=='yes')
                                                                <div class="card-tools">
                                                                    <a href="{{route('weeklyPlans.create')}}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Create</a>
                                                                </div>
                                                            @endif

                                                        @endif
                                                    @endif
                                                    
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap w-100" id="weeklyplans">
                                                <thead>
                                                    <tr>
                                                        <th>Creator</th>
                                                        <th>Start At</th>
                                                        <th>End At</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($weeklyPlans as $weeklyplan)
                                                        <tr>
                                                            <td>{{$weeklyplan->creator->name}}</td>
                                                            <td>{{$weeklyplan->start_at}}</td>
                                                            <td>{{$weeklyplan->end_at}}</td>
                                                            <td class="text-right">
                                                               
                                                                @if (auth()->user()->hasRole('product_specialist'))
                                                                    @if ($plan_access)
                                                                        <form action="{{ route('weeklyPlans.destroy' , $weeklyplan->id) }}" method="POST" class="d-inline-block">
                                                                            {{csrf_field()}}
                                                                            {{method_field('delete')}}
                                                                            <button type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                                                        </form>

                                                                    @else 
                                                                        @if (auth()->user()->allow_plan=='yes')
                                                                            <form action="{{ route('weeklyPlans.destroy' , $weeklyplan->id) }}" method="POST" class="d-inline-block">
                                                                                {{csrf_field()}}
                                                                                {{method_field('delete')}}
                                                                                <button type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                                                                            </form>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                
                                                                <button type="button" data-toggle="modal" data-target="#week_dayes{{$weeklyplan->id}}" class="btn btn-primary btn-sm" href="{{ route('weeklyPlans.edit' , $weeklyplan->id) }} "><i class="fa fa-edit"></i></button>
                                                                <a class="btn btn-success btn-sm" href="{{ route('weeklyPlans.show' , $weeklyplan->id) }} "><i class="fa fa-eye"></i></a>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="week_dayes{{$weeklyplan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Week Dayes</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="list-group text-left">
                                                                               @foreach ($weeklyplan->day as $day)
                                                                                    <a href="{{route('weeklyPlans.edit' , $day->id)}}" class="list-group-item list-group-item-action">{{date('l', strtotime($day->day_date)) }}</a> 
                                                                               @endforeach
                                                                                
                                                                                
                                                                            </div>
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
                                        {{$weeklyPlans->appends(request()->query())->links()}}
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
            $('#weeklyplans').DataTable( {
                "scrollX": true
            } );
        } );
    </script>
@endsection