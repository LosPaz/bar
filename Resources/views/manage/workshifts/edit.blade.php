@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifica turno</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manager.workshifts.update', $workshift->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Presente in cassa</label>
                            <input type="text" name="real_amount" class="form-control" value="{{ $workshift->real_amount }}"
                                required />
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button class="btn btn-primary btn-block">Salva</button>
                </div>
            </form>
        </div>
    </div>

@endsection