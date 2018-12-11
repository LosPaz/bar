@extends('layouts.unlogged', ['hideHome' => true])

@section('content')
    <form method="POST" class="card" action="{{ route('login') }}">
        @csrf
        <div class="card-body p-6">
            <div class="dimmer" id="dimmer">
                <div class="loader"></div>
                <div class="dimmer-content">
                    <div class="card-title text-center">
                        Accedi alla gestione bar
                    </div>
                    <div class="form-group text-center">
                        <label class="form-label">PIN</label>
                        <input type="number"
                               class="form-control{{ $errors->has('pin') ? ' is-invalid' : '' }}"
                               name="pin" id="pincode">
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-block">Accedi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('css')
    <link href="{{ asset('/assets/css/pincode.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/vendors/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/pincode.js') }}"></script>
    <script>
        $(document).ready(function () {
            let pinCode = $('#pincode').pincodeInput({
                inputs:6,
                complete: function(value, e, errorElement){
                    let pin = value;
                    $('#dimmer').toggleClass('active');
                    makeLogin(pin, function (data) {
                        $('#dimmer').toggleClass('active');
                        if(data.success){
                            window.location.href = '{{ route('bar.home') }}'
                        } else {
                            $(errorElement).html(data.msg);
                            pinCode.pincodeInput().data('plugin_pincodeInput').clear();
                        }
                    });
                }
            });

            function makeLogin(pin, success) {
                $.ajax({
                    url: '{{ route('bar.login') }}',
                    type: 'POST',
                    data: {_token: '{{ csrf_token() }}',pin:pin},
                    dataType: 'JSON',
                    success: success
                });
            }
        });
    </script>
@endpush