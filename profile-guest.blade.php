@extends('layouts.app')
@section('content')

<!-- Begin page -->
<main class="h-100">

    <!-- Header -->
    <header class="header position-fixed">
        <div class="row">
            <div class="col-auto">
                <a href="javascript:void(0)" target="_self" class="btn btn-light btn-44 menu-btn">
                    <i class="bi bi-list"></i>
                </a>
            </div>
            <div class="col align-self-center text-center">
                @include('layouts.logo')
            </div>
            <div class="col-auto">
                <a href="notifications.html" target="_self" class="btn btn-light btn-44">
                    <i class="bi bi-bell"></i>
                    <span class="count-indicator"></span>
                </a>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-0">
        <!-- user information -->
        @foreach ($sel_ab as $item)
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-auto">
                        <a href="">
                            <figure class="avatar avatar-60 rounded-10">
                                <img src="{{ '../' . $item->photoguest }}" alt="pict">
                            </figure>
                        </a>
                    </div>
                    <div class="col align-self-center">
                        <h3 class="col px-0 align-self-center text-color-theme">{{ $item->nameguest }}</h3>
                        <p class="text-muted size-12">{{ $item->phone }}</p>
                    </div>
                    <div class="col-auto">
                        <a href="" target="_blank" class="btn btn-44 btn-default shadow-sm ms-1">
                            <i class="bi bi-arrow-down-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body" id="">
                    <p class="text-muted mb-3">
                    </p>
                    <div class="row">
                        <div class="col d-grid">
                            <a href="" class="btn btn-default btn-lg shadow-sm">#1 - View Self Description</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endforeach
        <!-- followers and connections -->
        <div class="row mb-4 text-center py-4 bg-theme-light">
            <div class="col">
                <h6 class="mb-0">+254</h6>
                <p class="text-muted small">Followers</p>
            </div>
            <div class="col">
                <h6 class="mb-0">+124</h6>
                <p class="text-muted small">Connections</p>
            </div>
            <div class="col">
                <h6 class="mb-0">+1456</h6>
                <p class="text-muted small">Friends</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6 col-md-4">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-40 bg-warning text-white shadow-sm rounded-10-end">
                                    <i class="bi bi-star"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="text-muted size-12 mb-0">Attending Events</p>
                                <p>48546 pts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto px-0">
                                <div class="avatar avatar-40 bg-success text-white shadow-sm rounded-10-end">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="text-muted size-12 mb-0">Cashback</p>
                                <p>15 USD</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3" id="pageguest">
            <div class="col">
                <h6>Guest Info</h6>
            </div>
        </div>

        <div class="row h-100 mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-group form-floating  mb-3">
                    @foreach($sel_ab as $item)
                    <input readonly type="text" class="form-control" value="{{ $item->nameguest }}" placeholder="Name" id="nameguest" name="nameguest">
                    <label for="names">Name Guest </label>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-group form-floating  mb-3">
                    @foreach($sel_ab as $item)
                    <input readonly type="text" class="form-control" value="{{ $item->phone }}" placeholder="Mobile Number" id="mobilenumber" name="phone">
                    <label for="names">Mobile Number</label>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-group form-floating  mb-3">
                    @foreach($sel_ab as $item)
                    <input readonly type="text" class="form-control" value="{{ $item->address }}" placeholder="Address" id="address" name="address">
                    <label for="names">Address</label>
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-group form-floating  mb-3">
                    @foreach($sel_ab as $item)
                    <input readonly type="text" class="form-control" value="{{ $item->noteguest }}" placeholder="Note Guest" id="noteguest" name="noteguest">
                    <label for="names">Notes</label>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-group form-floating  mb-3">
                    @foreach($sel_ab as $item)
                    <input readonly type="text" class="form-control" value="{{ $item->numberguest }}" placeholder="Number Guest" id="numberguest" name="numberguest">
                    <label for="names">Number Guest</label>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-group form-floating  mb-3">
                    <input readonly type="text" class="form-control" value="{{ $organizations[0]->namechurch }}" placeholder="Organizations" id="organizations" name="organizations">
                    <label for="names">Organizations</label>
                </div>
            </div>
            <div class="card-body col-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col d-grid">
                        <a href="{{ url('edit-guest/' . $item->id_guest) }}" class="btn btn-default btn-lg shadow-sm">#2 - View Guest</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- main page content ends -->

</main>
<!-- Page ends-->

@endsection