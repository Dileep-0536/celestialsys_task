@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
  <div class="card-header">
    {{ __('Edit Employee') }}
  </div>
  <div class="card-body">
      <form method="post" action="{{ route('employees.update',$e_data->id) }}" id="update_employee_form">
        @csrf
        @method('PUT')
          <div class="row mb-3">
              <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }} :</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $e_data->first_name }}"/>
                    <span class="text-danger" id="first_nameError"></span>
                </div>
          </div> 
          <div class="row mb-3">
              <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }} :</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $e_data->last_name }}"/>
                    <span class="text-danger" id="last_nameError"></span>
                </div>
          </div>
          <div class="row mb-3">
              <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }} :</label>
              <div class="col-md-6">
              <input type="text" class="form-control" name="email" id="email" value="{{ $e_data->email }}"/>
              <span class="text-danger" id="emailError"></span>
              </div>
          </div>
          <div class="row mb-3">
              <label for="company_id" class="col-md-4 col-form-label text-md-end">{{ _('Company') }} :</label>
              <div class="col-md-6">
                <select name="company_id" id="company_id" class="form-control">
                    <option value="">Select Company</option>
                    @foreach($get_companies as $get_company)
                        <option value="{{ $get_company->id }}"<?php echo ($get_company->id == $e_data->company_id) ? "selected='selected'":""; ?>>{{ $get_company->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger" id="company_idError"></span>
              </div>
          </div>
          <div class="row mb-3">
              <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }} :</label>
              <div class="col-md-6">
              <input type="text" class="form-control" name="phone" id="phone" value="{{ $e_data->phone }}"/>
              <span class="text-danger" id="phoneError"></span>
                </div>
          </div>
            <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">{{ __('Edit Employee') }}</button>
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
        $("#update_employee_form").on('submit', function(e){
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