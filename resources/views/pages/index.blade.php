@extends('layouts.master')
@section('title', 'Home')
@push('css')
    <style>
        .dash-link{
            text-decoration: none;
            color: #000;
        }
    </style>
@endpush
@section('main-content')
<main>
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Dashboard</span>
        </div>
        <div class="row mt-3">
            <div class="dashboard-logo text-center pt-2 pb-4">
                <img class="border p-2" src="{{ asset('images/ibs-admin.png') }}" alt="">
            </div>
            @if(Auth::user()->username == 'SuperAdmin')
            <div class="col-xl-3 col-md-6">
                <a class="dash-link" href="{{ route('register') }}">
                    <div class="card mb-3 dashboard-card">
                        <div class="card-body mx-auto">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-user-plus fa-2x"></i>
                            </div>
                            <p class="dashboard-card-text">User Create</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a class="dash-link" href="{{ route('role.index') }}">
                    <div class="card mb-3 dashboard-card">
                        <div class="card-body mx-auto">
                            <div class=" d-flex justify-content-center align-items-center">
                                <i class="fas fa-user-tag fa-2x"></i>
                            </div>
                            <p class="dashboard-card-text">Role Create</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a class="dash-link" href="{{ route('permission.index') }}">
                    <div class="card mb-3 dashboard-card">
                        <div class="card-body mx-auto">
                            <div class=" d-flex justify-content-center align-items-center">
                                <i class="far fa-file-alt fa-2x"></i>
                            </div>
                            <p class="dashboard-card-text">Permission Create</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a class="dash-link" href="{{ route('coordinator.index') }}">
                    <div class="card mb-3 dashboard-card">
                        <div class="card-body mx-auto">
                            <div class=" d-flex justify-content-center align-items-center">
                                <i class="far fa-file-pdf fa-2x"></i>
                            </div>
                            <p class="dashboard-card-text">Coordinator Create</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a class="dash-link" href="{{ route('buyer.index') }}">
                    <div class="card mb-3 dashboard-card">
                        <div class="card-body mx-auto">
                            <div class=" d-flex justify-content-center align-items-center">
                                <i class="fa fa-users fa-2x"></i>
                            </div>
                            <p class="dashboard-card-text">Buyer Create</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a class="dash-link" href="{{ route('sample.index') }}">
                    <div class="card mb-3 dashboard-card">
                        <div class="card-body mx-auto">
                            <div class=" d-flex justify-content-center align-items-center">
                                <i class="fab fa-product-hunt fa-2x"></i>
                            </div>
                            <p class="dashboard-card-text">Sample List</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a class="dash-link" href="{{ route('product.data.wise.search') }}">
                    <div class="card mb-3 dashboard-card">
                        <div class="card-body mx-auto">
                            <div class=" d-flex justify-content-center align-items-center">
                                <i class="fas fa-search-plus fa-2x"></i>
                            </div>
                            <p class="dashboard-card-text">Product Search</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a class="dash-link" class="dash-link" href="{{ route('logout') }}">
                    <div class="card mb-3 dashboard-card">
                        <div class="card-body mx-auto">
                            <div class=" d-flex justify-content-center align-items-center">
                                <i class="fa fa-sign-out-alt fa-2x"></i>
                            </div>
                            <p class="dashboard-card-text">Log Out</p>
                        </div>
                    </div>  
                </a>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection