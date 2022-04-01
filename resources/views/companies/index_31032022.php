@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>

                <div class="card-body">
                    <div class='btn-group'>
                        <a href="{{ url('companies/create') }}" Type="button" class="btn btn-success">{{ __('Create new company') }}</a>
                    </div>
                </div>
                <div class='card'>
                @if(session('success'))
                <div class='alert alert-success'>{{session('success')}}</div>
                @endif
                @if(session('error_msg'))
                    <div class='alert alert-danger'>{{session('error_msg')}}</div>
                @endif
                    <div class="card-header">{{ __('Companies List') }}</div>
                    <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Website</th>
                                <th>Email</th>
                                <th colspan='3'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!$companies->isEmpty())
                            @php $i = 1; @endphp
                            @foreach($companies as $company)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ ucwords($company->name) }}</td>
                                    <td>{{ $company->address  }}</td>
                                    <td>{{ $company->website  }}</td>
                                    <td>{{ $company->email  }}</td>
                                    @php
                                    $company_id = Crypt::encryptString($company->id);
                                    @endphp
                                    <td>
                                    <form action="{{ route('companies.destroy', $company_id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('companies.show', $company_id)}}" class="btn btn-primary"><i class='fa fa-eye'></i></a>
                                        &nbsp;&nbsp;
                                        <a href="{{ route('companies.edit', $company_id) }}" class='btn btn-success'><i class='fa fa-pencil'></i></a>
                                        &nbsp;&nbsp;
                                        
                                       
                                        <button class="btn btn-danger" type="submit"><i class='fa fa-trash'></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td class="alert alert-danger text-center" colspan="6"><strong>No Records Found</strong></td></tr>
                        @endif
                        </tbody>
                    </table>
                    {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection