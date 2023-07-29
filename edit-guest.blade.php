@extends('layouts.app')

@section('content')
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed">
        <div class="row">
            <div class="col-auto">
                <button class="btn btn-light back-btn">
                    <i class="bi bi-arrow-left"> </i>Cancel
                </button>
            </div>
            <div class="col align-self-center text-center">
                <h5>Guest Info</h5>
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
    <div class="main-container container">
        <!-- user information -->
        <div class="card shadow-sm mb-4">
            @foreach($sel_ab as $item)
            <div class="card-header">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-50 shadow rounded-10 text-white">
                            <img src="{{ '../' . $item->photoguest }}" alt="pict">
                        </figure>
                    </div>
                    <div class="col px-0 align-self-center">
                        <h5>{{ $item->nameguest }}</h5>
                        <p class="text-muted ">{{ $item->phone }} </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- profile information -->
        <div class="row mb-3">
            <div class="col">
                <h6>Guest Info</h6>
            </div>
        </div>


        <form action="{{ url('profile-guest/ . $get_id') }}" method="post">
            @csrf

            <div class="row h-100 mb-4">
                <div class="alert alert-danger alert-block" style="display: none;">
                    <strong id="showError"></strong>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group form-floating  mb-3">
                        @foreach($sel_ab as $item)
                        <input type="text" class="form-control" value="{{ $item->nameguest }}" placeholder="Name" id="nameguest" name="nameguest">
                        <label for="nameguest">Name Guest</label>
                        <p class="text-danger" id="nameguest--empty" style="display: none;">Please fill in this field</p>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group form-floating  mb-3">
                        @foreach($sel_ab as $item)
                        <input type="text" class="form-control" value="{{ $item->phone }}" placeholder="Mobile Number" id="mobilenumber" name="phone">
                        <label for="mobilenumber">Mobile Number</label>
                        <p class="text-danger" id="mobilenumber--empty" style="display: none;">Please fill in this field</p>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group form-floating  mb-3">
                        @foreach($sel_ab as $item)
                        <input type="text" class="form-control" value="{{ $item->address }}" placeholder="Address" id="address" name="address">
                        <label for="address">Address</label>
                        <p class="text-danger" id="address--empty" style="display: none;">Please fill in this field</p>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group form-floating  mb-3">
                        @foreach($sel_ab as $item)
                        <input type="text" class="form-control" value="{{ $item->noteguest }}" placeholder="Note guest" id="noteguest" name="noteguest">
                        <label for="notes">Notes</label>
                        <p class="text-danger" id="noteguest--empty" style="display: none;">Please fill in this field</p>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group form-floating  mb-3">
                        @foreach($sel_ab as $item)
                        <input type="text" class="form-control" value="{{ $item->numberguest }}" placeholder="Number Guest" id="numberguest" name="numberguest">
                        <label for="numberguest">Number Guest</label>
                        <p class="text-danger" id="numberguest--empty" style="display: none;">Please fill in this field</p>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group form-floating  mb-3">
                        <select name="id_church" class="form-control">
                            @foreach($organizations as $item)
                            <option value="{{ $organizations->id_church }}" @if($item->id_church == $sel_ab->id_church) selected @endif>{{ $item->namechurch }}></option>
                            @endforeach
                        </select>
                        <label for="organizations">Organizations</label>
                        <!-- <p class="text-danger" id="organizations" style="display: none;">Please fill in this field</p> -->
                    </div>
                </div>
                @foreach($sel_ab as $item)
                <input type="hidden" name="get_id" value="{{ Crypt::encrypt($item->id_guest) }}">
                @endforeach

            </div>

            <div class="position-fixed bottom-0 start-50 translate-middle-x  z-index-10" id="konfirmasi">
                <div class="toast toast-save mb-3 fade hide" role="alert" aria-live="assertive" aria-atomic="true" id="toastSimpan" data-bs-animation="true">
                    <div class="toast-header">
                        <img src="{{ asset('assets/img/logo_inch.png') }}" width="20px" class="rounded me-2" alt="...">
                        <strong class="me-auto">PERHATIAN!</strong>
                        <!-- <small>now</small> -->
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <div class="row">
                            <div class="col save">
                                Apakah Anda yakin ingin menyimpan ini?
                            </div>
                            <div class="col delete">
                                Apakah Anda yakin ingin menghapus ini?
                            </div>
                            <div class="col-auto align-self-center ps-0">
                                <button class="btn btn-sm btn-default btn-save" type="submit">Save</button>
                                <a href="" class="btn btn-sm btn-default btn-delete">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-container container">
                <div class="row h-100 ">
                    <div class="col-md-6 mb-1">
                        <!-- <button class="btn btn-lg btn-default shadow btn-block" type="submit">Save</button> -->
                        <button class="btn btn-lg btn-default w-100 shadow" type="button" onclick="return save()">Save</button>
                    </div>
                    <div class="col-md-6 mb-1">
                        <button class="btn btn-lg btn-danger w-100 shadow text-white" type="button" disabled onclick="return hapus()">Delete</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <!-- main page content ends -->
</main>

@endsection

@section('script')
<script>
    function save() {
        // alert('masuk')
        let isInvalid = false;

        if (!$('#nameguest').val()) {
            $("#nameguest--empty").css("display", "");
            isInvalid = true;
        } else {
            $("#nameguest--empty").css("display", "none");
        }

        if (!$('#mobilenumber').val()) {
            $("#mobilenumber--empty").css("display", "");
            isInvalid = true;
        } else {
            $("#mobilenumber--empty").css("display", "none");
        }

        if (!$('#address').val()) {
            $("#address--empty").css("display", "");
            isInvalid = true;
        } else {
            $("#address--empty").css("display", "none");
        }

        if (!$('#noteguest').val()) {
            $("#noteguest--empty").css("display", "");
            isInvalid = true;
        } else {
            $("#noteguest--empty").css("display", "none");
        }

        if (!$('#numberguest').val()) {
            $("#numberguest--empty").css("display", "");
            isInvalid = true;
        } else {
            $("#numberguest--empty").css("display", "none");
        }

        if (!isInvalid) {
            // alert('oke')
            $('.toast-save').toast('show');
            $(".btn-save").show();
            $(".save").show();
            $(".btn-delete").hide();
            $(".delete").hide();
        }
    }

    function hapus() {
        $('.toast-save').toast('show');
        $(".btn-save").hide();
        $(".save").hide();
        $(".btn-delete").show();
        $(".delete").show();
    }
</script>

@endsection