@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.report-management.title')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endsection

<style type="text/css">
  .custom-select2 .form-control-inner label {
    position: absolute;
    left: 10px;
    top: -8px;
    background-color: #fff;
    padding: 0 5px;
    z-index: 1;
    font-size: 12px;
}
.custom-select2 .form-control-inner {
    position: relative;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 41px !important;
}

#chartdiv {
    width: 100%;
    max-width: 600px;
    height: 500px;
    margin: 0 auto;
}
g[aria-labelledby="id-66-title"]{
    display: none !important;
}
</style>

@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-body">
          <div class="row">
            <div class="col-12">
                <div class="card pt-2">
                    <div class="card-body">
                        <div class="row align-items-center cart_filter_box">
                          <div class="col">
                              <form id="categoryreport">
                                <div class="row align-items-center pb-3 mb-4 cart_filter_box">
                                  <div class="col-md-3 pr-0">
                                    <div class="custom-select2 fullselect2">
                                          <div class="form-control-inner">
                                              <label for="address_id">@lang('quickadmin.customers.fields.select_address')</label>
                                              <select class="js-example-basic-single @error('address_id') is-invalid @enderror" name="address_id" id="address_id" >
                                                  <option value="">@lang('quickadmin.customers.fields.select_address')</option>
                                                   @foreach($addresses as $address)
                                                    <option value="{{ $address->id }}">{{ $address->address }}</option>
                                                   @endforeach
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3 pr-0">
                                    <div class="datapikergroup custom-select2 datepickerbox">
                                        <div class="form-control-inner">
                                            <label for="select_date">Select Date</label>
                                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                                <span></span> <b class="caret"></b>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-2 pr-0">
                                    <div class="form-group d-flex m-0">
                                          <button type="submit" class="btn btn-primary mr-1 col" id="apply-filter">@lang('quickadmin.qa_submit')</button>
                                          <button type="reset" class="btn btn-primary mr-1 col" id="reset-filter">@lang('quickadmin.qa_reset')</button>
                                      </div>
                                  </div>
                                  <div class="col-md-4 text-end">
                                    <div class="form-group mb-0 d-flex justify-content-end">
                                      <div class="col-auto px-md-1 pr-1">
                                        <a href="" class="btn printbtn h-10 col circlebtn" id="report-print">
                                          <x-svg-icon icon="print" />
                                        </a>
                                      </div>
                                      <!--  -->
                                      <div class="col-auto px-md-1 pr-1">
                                        <a href="" class="btn excelbtn h-10 col circlebtn" id="report-excel">
                                          <x-svg-icon icon="excel" />
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </form>
                          </div>
                        </div>
                    </div>
                    <div class="col">
                     <div id="chartdiv"></div>
                    </div>
                      <div class="col">
                        <div class="table-responsive fixed_Search">
                            {{$dataTable->table(['class' => 'table dt-responsive categoryReportdatatable dropdownBtnTable', 'style' => 'width:100%;','id'=>'dataaTable'])}}
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
  </section>
@endsection


@section('customJS')
{!! $dataTable->scripts() !!}
<script src="{{ asset('admintheme/assets/bundles/datatables/datatables.min.js') }}"></script>
 <script src="{{ asset('admintheme/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admintheme/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('admintheme/assets/js/page/datatables.js') }}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script type="text/javascript">
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
    });
</script>

<script>
    am4core.ready(function() {
    am4core.useTheme(am4themes_animated);
    var chart;
    if (!chart) {
        // If not, create a new chart
        chart = am4core.create("chartdiv", am4charts.PieChart3D);
        chart.hiddenState.properties.opacity = 0;
        chart.legend = new am4charts.Legend();
        chart.legend.position = "right";
    }

    window.updatepieChart = function(params=null) {
        console.log('called');
        $.ajax({
            type: 'GET',
            url: "{{ route('reports.category.piechart') }}",
            data: params,
            dataType: 'json',
            success: function(response) {
                //console.log(response);
                chart.series.clear();
                chart.data = response;
                var series = chart.series.push(new am4charts.PieSeries3D());
                series.alignLabels = false;
                series.labels.template.disabled = true;
                series.dataFields.value = "amount";
                series.dataFields.category = "category";
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    // Call the function initially to load the chart
    updatepieChart();
    });


</script>

<script>
$(document).ready(function(){
    var dataTable = $('#dataaTable').DataTable();

    $('#categoryreport').on('submit', function(e) {
        e.preventDefault();
        // Get the date range picker instance
        var picker = $('#reportrange').data('daterangepicker');
        // Retrieve the selected start and end dates
        var from_date = picker.startDate.format('YYYY-MM-DD');
        var to_date = picker.endDate.format('YYYY-MM-DD');
        // Collect filter values (address, from_date, to_date) from the form
        var address_id = $('#address_id').val();
        if(address_id == undefined){
            address_id = '';
        }

        if(from_date == undefined || from_date == 'Invalid date'){
            from_date = '';
        }

        if(to_date == undefined || to_date == 'Invalid date'){
            to_date = '';
        }

        console.log('address_id',address_id);
        console.log('from_date',from_date);
        console.log('to_date',to_date);

        var params = {
                address_id      : address_id,
                from_date        : from_date,
                to_date          : to_date,
        };

        dataTable.ajax.url("{{ route('reports.category') }}"+ "?" +$.param(params)).load();
        /// for update pichart according to filter ......
        updatepieChart(params);
        // $('#report-excel').attr('href', exportUrl);
        // $('#report-print').attr('href', printUrl);
    });



});
</script>

@endsection
