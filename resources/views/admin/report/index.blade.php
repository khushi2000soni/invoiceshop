@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.report-management.title')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-body">
          <div class="row">
                <div class="col-lg8 col-md-6 col-sm-12">
                    <div class="card ">
                    <div class="card-body card-type-3">
                        <div class="row">
                            <div class="col">
                                <h5 class="mt-1 mb-1">@lang('quickadmin.reports.order')</h5>
                            </div>
                            <div class="col">
                                <div class="form-group mb-1">
                                    <select id="timeFrameOrderChartSelect" class="form-select">
                                        {{-- <option value="monthly" {{ $timeFrame === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="weekly" {{ $timeFrame === 'weekly' ? 'selected' : '' }}>Weekly</option> --}}
                                        <option value="monthly">@lang('quickadmin.reports.monthly')</option>
                                        <option value="weekly">@lang('quickadmin.reports.weekly')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-chart mb-2 ml-4 mr-4">
                            <canvas id="orderChart"></canvas>
                    </div>
                    </div>
                </div>
                <div class="col-lg8 col-md-6 col-sm-12">
                    <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="card card-info shadow">
                                    <div class="card-header">
                                        <div class="card-square l-bg-cyan text-white rounded">
                                            <i class="fas fa-shopping-cart p-2"></i>
                                        </div>
                                        <h4 class="mx-2">@lang('quickadmin.reports.total_order')</h4>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $totalOrderCount }}</h4>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="card card-info shadow" >
                                    <div class="card-header">
                                        <div class="card-square l-bg-cyan text-white rounded">
                                            <i class="fas fa-user-plus p-2"></i>
                                        </div>
                                        <h4 class="mx-2">@lang('quickadmin.reports.total_customer')</h4>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $totalCustomerCount }}</h4>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="card card-info shadow">
                                    <div class="card-header">
                                        <div class="card-square l-bg-cyan text-white rounded">
                                            <i class="far fa-credit-card p-2"></i>
                                        </div>
                                        <h4 class="mx-2">@lang('quickadmin.reports.total_product')</h4>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $totalProductCount }}</h4>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="card card-info shadow">
                                    <div class="card-header">
                                        <div class="card-square l-bg-cyan text-white rounded">
                                            <i class="fas fa-mobile-alt p-2"></i>
                                        </div>
                                        <h4 class="mx-2 me-0">@lang('quickadmin.reports.no_of_devices')</h4>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $deviceCount }}</h4>
                                    </div>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="col-lg4 col-md-6 col-12 col-sm-12">
                    <div class="card overflow-hidden h-100">
                      <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mt-1 mb-1">@lang('quickadmin.reports.order')</h5>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-1">
                                    <select id="timeFrameOrderSelectTable" class="form-select">
                                        <option value="today">@lang('quickadmin.reports.today')</option>
                                        <option value="7days">@lang('quickadmin.reports.7days')</option>
                                        <option value="30days">@lang('quickadmin.reports.30days')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="card-body" style="max-height: 430px;  overflow-y: auto;">
                        <div class="table-responsive">
                          <table class="table" id="order-table-body">
                            <thead>
                            <tr>
                              <th class="py-0">@lang('quickadmin.reports.customer')</th>
                              <th class="py-0 text-center">@lang('quickadmin.reports.amount')</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                          </table>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                    <div class="card overflow-hidden h-100">
                      <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mt-1 mb-1" style="white-space: nowrap;">@lang('quickadmin.reports.products')</h5>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-1">
                                    <select id="timeFrameProductSelectTable" class="form-select">
                                        <option value="today">@lang('quickadmin.reports.today')</option>
                                        <option value="7days">@lang('quickadmin.reports.7days')</option>
                                        <option value="30days">@lang('quickadmin.reports.30days')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="card-body" style="max-height: 430px;  overflow-y: auto;">
                        <div class="table-responsive">
                          <table class="table" id="product-table-body">
                          <thead >
                            <tr>
                              <th class="py-0">@lang('quickadmin.reports.products')</th>
                              <th class="py-0 text-center">@lang('quickadmin.reports.amount')</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                </div>
          </div>
    </div>
  </section>
@endsection


@section('customJS')
<script src="{{ asset('admintheme/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    var orderData = @json($data);

    var ctx = document.getElementById('orderChart').getContext('2d');
    var orderChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: orderData.labels,
            datasets: [{
                label: 'No. of Orders',
                data: orderData.values,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5, // Adjust the step size to change line height
                    },
                }
            },
        }
    });

    function updateChart(timeFrame) {
        var data = { timeFrame: timeFrame };
        $.ajax({
            type: 'GET',
            url: "{{ route('fetchReportData') }}",
            data: data,
            success: function(response) {
                var newData = response.data;
                console.log('newData', newData);
                orderChart.data.labels = newData.labels;
                orderChart.data.datasets[0].data = newData.values;
                orderChart.update();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    // Initialize the chart with the default data (monthly)
    updateChart('monthly');

    // Handle the time frame select change for the chart
    $('#timeFrameOrderChartSelect').on('change', function(e) {
        e.preventDefault();
        var selectedTimeFrame = this.value;
        updateChart(selectedTimeFrame);
    });


    // Function to update the table data
    function updateTableData(timeFrame) {
        var data = { timeFrame: timeFrame };
        $.ajax({
            type: 'GET',
            url: "{{ route('fetchReportData') }}",
            data: data,
            success: function(response) {
                var newData = response.data;
                console.log('newData', newData);

                // Update the table content
                var tableBody = $('#order-table-body tbody');
                tableBody.empty();
                newData.forEach(function(order) {
                    var row = '<tr><td><div class="media-body"><div class="media-tab-title font-weight-bold">' + order.customer.name + '</div>' +
                              '<div class="text-job text-muted">#' + order.invoice_number + '</div></div></td><td>' + order.grand_total  + '</td></tr>';
                    tableBody.append(row);
                });
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    // Handle the time frame select change for the table
    $('#timeFrameOrderSelectTable').on('change', function(e) {
        e.preventDefault();
        var selectedTimeFrame = this.value;
        updateTableData(selectedTimeFrame);
    });

    // Load the default data when the page loads
    updateTableData('today');

    $('#timeFrameProductSelectTable').on('change', function(e) {
        e.preventDefault();
        var selectedTimeFrame = this.value;
        updateProductTable(selectedTimeFrame);
    });

    // Function to update the product table data
    function updateProductTable(timeFrame) {
        var data = { timeFrame: timeFrame };

        $.ajax({
            type: 'GET',
            url: "{{ route('getSoldProducts') }}",
            data: data,
            success: function(response) {
                var soldProducts = response.data;
                console.log('soldProducts', soldProducts);

                // Update the product table content
                var tableBody = $('#product-table-body tbody');
                tableBody.empty();

                soldProducts.forEach(function(product) {
                    var row = '<tr><td>' +
                        '<div class="media-body">' +
                        '<div class="media-tab-title font-weight-bold">' + product.name + '</div>' +
                        '<div class="text-muted">Sold Units - ' + product.total_sold_units + '</div>' +
                        '</div></td><td>' + product.total_price + '</td></tr>';
                    tableBody.append(row);
                });
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    // Load the default data when the page loads
    updateProductTable('today');
});
</script>


@endsection
