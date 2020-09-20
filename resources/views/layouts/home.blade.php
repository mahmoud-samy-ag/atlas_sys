@extends('layouts.index')






@section('layouts.content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container">
        <!-- Small boxes (Stat box) -->

        <div class="row">
          <div class="col-md-3 card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap w-100" id="data_table">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th class="text-right">Feedback</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($products as $product)
                          <tr>
                              <td>{{$product->name}}</td>
                              <td class="text-right">
                                <a href="{{route('product_feedback' , $product->id)}}" target="_blank" class="btn btn-success btn-sm" ><i class="fa fa-eye"></i></a>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
                  
              </table>
          </div>
          <!-- /.card-body -->
          </div>
          <div class="col-md-9 col-12">
            @if (auth()->user()->hasRole('product_specialist'))
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{$week_visited_customers}} / {{$all_customers}}</h3>

                    <p>Total visits this week</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                </div>
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{$month_visited_customers}} / {{$all_customers}}</h3>

                    <p>Total visits this month</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                </div>
            @endif
              <form action="{{ route('home') }}" method="GET" class="input-group">
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
            <div id="salesreport" style="height: 250px;"></div>
            @if (!(auth()->user()->hasRole('product_specialist')))
            <div class="product_specialists">
              <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#product_specialists" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fas fa-list"></i> Product Specialists</a>
              </p>
              <div class="row">
                <div class="col">
                  <div class="collapse multi-collapse" id="product_specialists">
                    <div class="card card-body">
                      <div class="list-group">
                        @foreach ($product_specialists as $product_specialist)
                          <a href="{{url('sales_graph' , $product_specialist->id)}}" class="list-group-item list-group-item-action">{{$product_specialist->name}}</a>
                        @endforeach
                        
                        
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
            @endif
        </div>

        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection




@section('layouts.scripts')
<script>
  new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'salesreport',
  data: [


    @if(empty($salesReports[0]))
    { period: '{{date('now')}}', park1:0, park2: 0, park3: 0},
    @else
      @php 
        $ucp=0;
        $direct_sales=0;
        $total=0;
      @endphp
      @foreach($salesReports as $data)
        @php 
          $ucp +=$data->ucp;
          $direct_sales +=$data->direct_sales;
          $total +=$data->ucp + $data->direct_sales;
        @endphp
        { period: '{{date('Y-m-d', strtotime($data->date))}}', park1: {{$ucp}}, park2: {{$direct_sales}}, park3: {{$total}}},
      @endforeach
    @endif


    

   

  ],
  lineColors: ['#819C79', '#fc8710', '#FF6541'],
  xkey: 'period',
  ykeys: ['park1','park2','park3'],
  labels: ['UCP', 'direct sales', 'total'],
  xLabels: 'week',
  xLabelAngle: 45,
  
  resize: true
});
</script>
@endsection