@extends('admin.layouts.app')
@section('title')Add Employee @endsection
@section('metdescp')Add Employee @endsection

@section('main-content')

<section class="section">
    <div class="section-header ">
      <h1>Add Employee</h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employee List</a></div>
        <div class="breadcrumb-item">Add Employee</div>
      </div>
    </div>
    <div class="section-body">
      <div class="row">       
       
        <div class="col-12 col-md-12 col-lg-12">
          @include('admin.message')
          <div class="card">
            <form action="{{ route('employees.store') }}" method="POST" id="employeeForm" name="employeeForm" enctype="multipart/form-data">
             @csrf
             <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Employee Name</label>
                            <input type="text" class="form-control @error('name') is-invalid                              
                            @enderror" name="name" id="name"  value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                           
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid                                
                            @enderror" name="email" id="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone No.</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid                                
                            @enderror" name="phone_number" id="phone_number" value="{{ old('phone_number') }}">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control @error('city') is-invalid                                
                            @enderror" name="city" id="city" value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Age</label>
                            <input type="number" class="form-control @error('age') is-invalid                               
                            @enderror" name="age" id="age" value="{{ old('age') }}">
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Address</label>
                            <textarea class="form-control @error('address') is-invalid                                
                            @enderror" name="address" id="address" >{{ old('address') }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Profile Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label>Joining Date </label>
                            <input type="date" class="form-control @error('joining_date') is-invalid                                
                            @enderror" name="joining_date" id="joining_date" value="{{ old('joining_date') }}">
                            @error('joining_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                    </div>
               </div>              
                
                
              </div>
              <div class="card-footer text-left">
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection

@section('customJS')

@endsection