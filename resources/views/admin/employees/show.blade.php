@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Employee') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 mx-3 mt-5">
                                <h1>Company : {{ $employee->companies->name }}</h1>
                                <p>Name : {{ $employee->first_name }} {{ $employee->last_name }}</p>
                                <p>Email : {{ $employee->email }}</p>
                                <p>Phone : {{ $employee->phone }}</p>
                            </div>
                            <div class="col-lg-6 mx-4">
                                <img src="{{ asset('storage/' . $employee->companies->logo) }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
