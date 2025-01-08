@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Create Employees') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('/employees') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" name="id_companies">
                                    <option selected>--- Select Company ---</option>
                                    @foreach ($companies as $companie)
                                        <option value="{{ $companie->id }}">{{ $companie->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
