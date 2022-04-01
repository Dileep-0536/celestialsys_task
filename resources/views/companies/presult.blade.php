<table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Website</th>
                                <th>Email</th>
                                <th>Logo</th>
                                <th colspan='2'>Action</th>
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
                                    <td><a href="<?php echo asset("storage/company_logos/$company->logo")?>" target="_blank"><img src="<?php echo asset("storage/company_logos/$company->logo")?>" alt=""></a></td>
                                    @php
                                    $company_id = Crypt::encryptString($company->id);
                                    @endphp
                                    <td>
                                    <form action="{{ route('companies.destroy', $company_id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('companies.show', $company_id) }}" class='btn btn-primary' title="View Company Employees"><i class='fa fa-eye'></i></a>
                                        &nbsp;&nbsp;
                                        <a href="{{ route('companies.edit', $company_id) }}" class='btn btn-success' title="Edit Company"><i class='fa fa-pencil'></i></a>
                                        &nbsp;&nbsp;
                                        <button class="btn btn-danger" type="submit" title="Delete Company"><i class='fa fa-trash'></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td class="alert alert-danger text-center" colspan="7"><strong>No Records Found</strong></td></tr>
                        @endif
                        </tbody>
                    </table>
                    {{ $companies->links() }}