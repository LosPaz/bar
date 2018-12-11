@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuovo fornitore</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manager.suppliers.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" />
                        </div>
                    </div>

                </div>

                <div class="form-footer">
                    <button class="btn btn-primary btn-block">Crea</button>
                </div>
            </form>
        </div>
    </div>

@endsection