@extends('admin.layouts.app')
@section('title') Employee List @endsection
@section('metdescp')Employee List @endsection

@section('main-content')

<section class="section">
    <div class="section-header ">
      <h1> Employee List</h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('employees.create') }}">Add Employee  </a></div>
        <div class="breadcrumb-item">List of Employee</div>
      </div>
    </div>
    <div class="section-body">
                 @include("admin.message")
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Multi Select</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="table-2">
                      <thead>
                        <tr>
                          <th class="text-center pt-3">
                            <div class="custom-checkbox custom-checkbox-table custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                class="custom-control-input" id="checkbox-all">
                              <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                            </div>
                          </th>
                          <th>Id </th>
                          <th>Name</th>
                          <th>Image</th>
                          <th>Contact</th>
                          <th>Join Date</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if ($employees->isNotEmpty())
                            @foreach ($employees as $employee )
                                <tr>
                                    <td class="text-center pt-2">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                        id="checkbox-1">
                                        <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                    </div>
                                    </td>
                                    <td>{{ $employee->id }}</td>
                                    <td>{{ $employee->name }} <br>{{ $employee->city }},{{ $employee->address }}</td>
                                    <td>
                                        @if ($employee->image)
                                           <img src="{{ asset('storage/images/employees/' . $employee->image) }}" alt="{{ $employee->name }} Image" width="100">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $employee->email }} <br> {{ $employee->phone_number }}</td>
                                    <td>{{ $employee->joining_date->format('d-m-Y') }}</td>
                                    <td>
                                    @if ($employee->status == 'Active')
                                        <div class="badge badge-success badge-shadow">Active</div>
                                    @else
                                        <div class="badge badge-danger badge-shadow">Deactive</div>
                                    @endif
                                    
                                    </td>
                                    <td>
                                        <a href="{{ route('employees.edit',$employee->id) }}" class="btn btn-outline-info">Edit</a>
                                        <a href="#" class="btn btn-outline-primary">Detail</a>
                                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">No Record Found!</td>
                            </tr>
                        @endif
                        
                       
                       
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
  <script src="{{ asset('admintheme/assets/bundles/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('admintheme/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('admintheme/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('admintheme/assets/js/page/datatables.js') }}"></script>
@endsection