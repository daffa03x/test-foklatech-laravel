@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Employees') }}</div>

                    <div class="card-body">
                        @session('success')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endsession
                        @session('error')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endsession
                        <a class="btn btn-primary mb-2" href="{{ url('employees/create') }}">Create</a>
                        <div class="table-responsive"">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->phone }}</td>
                                            <td>{{ $employee->companies->name }}</td>
                                            <td>
                                                <div class=pt-2">
                                                    <form action="{{ url('employees/' . $employee->id) }}" method="POST">
                                                        <a href="{{ url('employees/' . $employee->id) }}"
                                                            class="btn badge bg-info btn-sm text-white mx-2">Show</a>
                                                        <a href="{{ url('employees/' . $employee->id . '/edit') }}"
                                                            class="btn badge bg-warning btn-sm text-white me-2">Edit</a>
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn badge bg-danger btn-sm">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $employees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
