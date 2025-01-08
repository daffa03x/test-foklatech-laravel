@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Companies') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 mx-3 mt-5">
                                <h1>Company : {{ $companie->name }}</h1>
                                <p>Email : {{ $companie->email }}</p>
                                <p>Webiste : <a href="{{ $companie->website }}">{{ $companie->website }}</a></p>
                            </div>
                            <div class="col-lg-6 mx-4">
                                <img src="{{ asset('storage/' . $companie->logo) }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
