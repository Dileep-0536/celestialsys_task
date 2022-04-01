@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
  <div class="card-header">
    {{ __('Add Employee') }}
  </div>
  <div class="card-body">
      <form method="post" action="{{ route('employees.store') }}" id="add_employee_form">
        @csrf
          <div class="row mb-3">
              <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }} :</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="first_name" id="first_name"/>
                    <span class="text-danger" id="first_nameError"></span>
                </div>
          </div> 
          <div class="row mb-3">
              <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }} :</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="last_name" id="last_name"/>
                    <span class="text-danger" id="last_nameError"></span>
                </div>
          </div>
          <div class="row mb-3">
              <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }} :</label>
              <div class="col-md-6">
              <input type="text" class="form-control" name="email" id="email"/>
              <span class="text-danger" id="emailError"></span>
              </div>
          </div>
          <div class="row mb-3">
              <label for="company_id" class="col-md-4 col-form-label text-md-end">{{ _('Company') }} :</label>
              <div class="col-md-6">
                <select name="company_id" id="company_id" class="form-control">
                    <option value="">Select Company</option>
                    @foreach($get_companies as $get_company)
                        <option value="{{ $get_company->id }}">{{ $get_company->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger" id="company_idError"></span>
              </div>
          </div>
          <div class="row mb-3">
              <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }} :</label>
              <div class="col-md-6">
              <input type="text" class="form-control" name="phone" id="phone"/>
              <span class="text-danger" id="phoneError"></span>
                </div>
          </div>
            <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">{{ __('Add Employee') }}</button>
            </div>
            </div>
      </form>
  </div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });
        $("#add_employee_form").on('submit', function(e){
            e.preventDefault();
            var datastring = $(this).serialize();
            $.ajax({
                url:$(this).attr('action'),
                type:"POST",
                data:datastring,
                dataType:"JSON",
                success: function(data){
                    console.log(data);
                    if(data.status == "success") {
                        alert(data.message);
                        $("#add_employee_form")[0].reset();
                        var link = "{{ url('employees') }}";
                        window.location.href = link;
                        return false;
                    } else {
                        alert(data.message);
                    }
                },
                error:function (response){
                    if(response.responseJSON.errors.first_name) {
                        $('#first_nameError').text(response.responseJSON.errors.first_name);
                    } else {
                        $('#first_nameError').text('');
                    }
                    if(response.responseJSON.errors.last_name) {
                        $('#last_nameError').text(response.responseJSON.errors.last_name);
                    } else {
                        $('#last_nameError').text('');
                    }
                    if(response.responseJSON.errors.email) {
                        $('#emailError').text(response.responseJSON.errors.email);
                    } else {
                        $('#emailError').text('');
                    }
                    if(response.responseJSON.errors.phone) {
                        $('#phoneError').text(response.responseJSON.errors.phone);
                    } else {
                        $('#phoneError').text('');
                    }
                    if(response.responseJSON.errors.company_id) {
                        $('#company_idError').text(response.responseJSON.errors.company_id);
                    } else {
                        $('#company_idError').text('');
                    }
                }
            });
        });
    });
</script>
@endpush