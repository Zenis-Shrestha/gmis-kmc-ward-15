@extends('dashboard')

@section('content')
@foreach($chartGroups as $key=>$chartGroup)
<h3>{{ $chartGroup['title'] }}</h3>
<div class="row">
    @foreach($chartGroup['charts'] as $index=>$chart)
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $chart['title'] }}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" style="height: 400px">
            <canvas id="canvas_{{ $key }}_{{ $index }}"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
    </div>
    @endforeach
</div>
@endforeach
<h3>Export Report</h3>
<div class="row">
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <a class="btn btn-info pdf" id="pdf">Export to PDF</a>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        @foreach($chartGroups as $key=>$chartGroup)
            @foreach($chartGroup['charts'] as $index=>$chart)
                @if($chart['type'] == 'pie')
                var {{ $key . $index }}Ctx = document.getElementById("canvas_{{ $key }}_{{ $index }}");

                var {{ $key . $index }}Data = {
                    labels: [<?php echo implode(',', $chart['labels']); ?>],
                    datasets: [
                        {
                            label: "No. of buildings",
                            backgroundColor: [<?php echo implode(',', $chart['colors']); ?>],
                            hoverBackgroundColor: [<?php echo implode(',', $chart['colors']); ?>],
                            data: [<?php echo implode(',', $chart['values']); ?>],
                        }
                    ]
                };

                var {{ $key . $index }}Chart = new Chart({{ $key . $index }}Ctx, {
                    type: 'pie',
                    data: {{ $key . $index }}Data,
                    options: {
                        legend: {
                            position: "{{ count($chart['labels']) < 5 ? 'right' : 'bottom' }}"
                        },
                        maintainAspectRatio: false
                    },
                    animation: {
                        animateScale:true
                    }
                });
                @elseif($chart['type'] == 'bar')
                var {{ $key . $index }}Ctx = document.getElementById("canvas_{{ $key }}_{{ $index }}");

                var {{ $key . $index }}Data = {
                    labels: [<?php echo implode(',', $chart['labels']); ?>],
                    datasets: [
                        {
                            label: <?php echo $chart['datasetLabel']; ?>,
                            backgroundColor: "rgba(255,99,132,0.2)",
                            borderColor: "rgba(255,99,132,1)",
                            borderWidth: 1,
                            hoverBackgroundColor: "rgba(255,99,132,0.4)",
                            hoverBorderColor: "rgba(255,99,132,1)",
                            data: [<?php echo implode(',', $chart['values']); ?>],
                        }
                    ]
                };

                var {{ $key . $index }}Chart = new Chart({{ $key . $index }}Ctx, {
                    type: 'bar',
                    data: {{ $key . $index }}Data,
                    animation: {
                        animateScale:true
                    },
                    options: {
                        legend: {
                            position: 'bottom'
                        },
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                @elseif($chart['type'] == 'bar_stacked')
                var {{ $key . $index }}Ctx = document.getElementById("canvas_{{ $key }}_{{ $index }}");

                var {{ $key . $index }}Data = {
                    labels: [<?php echo implode(',', $chart['labels']); ?>],
                    datasets: [
                        @foreach($chart['datasets'] as $dataset)
                        {
                            label: <?php echo $dataset['label']; ?>,
                            backgroundColor: <?php echo $dataset['color']; ?>,
                            data: [<?php echo implode(',', $dataset['data']); ?>],
                        },
                        @endforeach
                    ]
                };

                var {{ $key . $index }}Chart = new Chart({{ $key . $index }}Ctx, {
                    type: 'bar',
                    data: {{ $key . $index }}Data,
                    animation: {
                        animateScale:true
                    },
                    options: {
                        legend: {
                            position: 'bottom'
                        },
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        tooltips: {
                            mode: 'index'
                        }
                    }
                });
                @endif
            @endforeach
        @endforeach
        
    $('[id="pdf"]').click(function(e) {
        // e.preventDefault();
        
        const url = `tax-payment-dashboard/report/`;
        window.open(url, "Monthly Report");
    })
    });
</script>
@endpush