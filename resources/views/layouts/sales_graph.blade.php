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
            <div class="col-md-12 col-12">
                <!-- small box -->
               
                  <form action="{{ url('sales_graph' , $user_id) }}" method="GET" class="input-group">
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