@extends('admin.layouts.app')
@section('title')Add Category @endsection
@section('metdescp')Add Category @endsection

@section('main-content')

<section class="section">
    <div class="section-header ">
      <h1>Add Category</h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('categories.list') }}">Category List</a></div>
        <div class="breadcrumb-item">Add Category</div>
      </div>
    </div>
    <div class="section-body">
      <div class="row">       
       
        <div class="col-12 col-md-12 col-lg-12">
          @include('admin.message')
          <div class="card">
            <form action="" method="POST" id="categoryForm" name="categoryForm">
             <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="catname" id="catname" >
                            <p></p>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category Description</label>
                            <textarea class="form-control" name="catdescp" id="catdescp" ></textarea>
                            <p></p>
                          </div>
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category Image</label>
                            <input type="file" class="form-control" name="cimage">
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label>Category Priority</label>
                            <input type="number" class="form-control" name="cpriority" id="cpriority">
                            <p></p>
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
<script>
$('#categoryForm').submit(function(event){
    event.preventDefault();
    var element= $(this);
    $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url:'{{ route("categories.store") }}',
        type:'post',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
          $("button[type=submit]").prop('disabled',false);
            if(response.status == true){
                // Clear input fields and error messages (if any)
                    // $("#catname, #catdescp, #cpriority").removeClass('is-invalid');
                    // form.find('.invalid-feedback').html('');
                window.location.href="{{ route('categories.create') }}";
              
                $("#catname").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback').html("");             

              
                $("#catdescp").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback').html("");              

              
                $("#cpriority").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback').html("");              

            }else{
              var errors= response['errors'];
              if(errors['catname']){
                  $("#catname").addClass('is-invalid')
                  .siblings('p')
                  .addClass('invalid-feedback').html(errors['catname']);
              }else{
                $("#catname").removeClass('is-invalid')
                  .siblings('p')
                  .removeClass('invalid-feedback').html("");
              }

              if(errors['catdescp']){
                  $("#catdescp").addClass('is-invalid')
                  .siblings('p')
                  .addClass('invalid-feedback').html(errors['catdescp']);
              }else{
                  $("#catdescp").removeClass('is-invalid')
                  .siblings('p')
                  .removeClass('invalid-feedback').html("");
              }

              if(errors['cpriority']){
                  $("#cpriority")
                  .addClass('is-invalid')
                  .siblings('p')
                  .addClass('invalid-feedback').html(errors['cpriority']);
              }else{
                  $("#cpriority").removeClass('is-invalid')
                  .siblings('p')
                  .removeClass('invalid-feedback').html("");
              }

            }
            
        }, error: function(jqXHR,exception){
            console.log("Something went wrong");
        }
    })

});
</script>
@endsection