<table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th colspan='2'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!$employees->isEmpty())
                            @php $i = 1; @endphp
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ ucwords($employee->first_name." ".$employee->last_name) }}</td>
                                    <td>{{ $employee->company->name  }}</td>
                                    <td>{{ $employee->phone  }}</td>
                                    <td>{{ $employee->email  }}</td>
                                    @php
                                    $employee_id = Crypt::encryptString($employee->id);
                                    @endphp
                                    <td>
                                    <form action="{{ route('employees.destroy', $employee_id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        
                                        &nbsp;&nbsp;
                                        <a href="{{ route('employees.edit', $employee_id) }}" class='btn btn-success' title="Edit Employee"><i class='fa fa-pencil'></i></a>
                                        &nbsp;&nbsp;
                                        
                                       
                                        <button class="btn btn-danger" type="submit" title="Delete Employee"><i class='fa fa-trash'></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td class="alert alert-danger text-center" colspan="7"><strong>No Records Found</strong></td></tr>
                        @endif
                        </tbody>
                    </table>
                    {{ $employees->links() }}