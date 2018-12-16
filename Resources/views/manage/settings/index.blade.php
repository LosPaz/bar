@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Impostazioni</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('manager.settings.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Deposito di default per il bar</label>
                            <select name="default_repo" id="repository_id" class="form-control" required>
                                <option></option>
                                @foreach($repositories as $repository)
                                    <option value="{{ $repository->id }}"
                                            @if(Michelangelo\Confy\Models\Confy::getConfig('default_repo', 'settings') == $repository->id) selected @endif
                                    >
                                        {{ $repository->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-footer">
                    <button class="btn btn-primary btn-block">Aggiorna impostazioni</button>
                </div>
            </form>
        </div>
    </div>

@endsection