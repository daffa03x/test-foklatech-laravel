@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Companies') }}</div>

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
                        <a class="btn btn-primary mb-2" href="{{ url('companies/create') }}">Create</a>
                        <div class="table-responsive"">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Companies</th>
                                        <th>Email</th>
                                        <th>Logo</th>
                                        <th>Website</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $companie)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $companie->name }}</td>
                                            <td>{{ $companie->email }}</td>
                                            <td><img width="100px" src="{{ asset('storage/' . $companie->logo) }}"
                                                    alt=""></td>
                                            <td><a href="{{ $companie->website }}">{{ $companie->website }}</a></td>
                                            <td>
                                                <div class=pt-2">
                                                    <form action="{{ url('companies/' . $companie->id) }}" method="POST">
                                                        <a href="{{ url('companies/' . $companie->id) }}"
                                                            class="btn badge bg-info btn-sm text-white mx-2">Show</a>
                                                        <a href="{{ url('companies/' . $companie->id . '/edit') }}"
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
                            {{ $companies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
