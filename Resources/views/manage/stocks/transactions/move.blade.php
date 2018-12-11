@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sposta da deposito a deposito</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manager.stocks.transactions.move', $stock->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Vecchio deposito</label>
                            <select name="old_repo" id="old_repo" class="form-control" required>
                                <option></option>
                                @foreach($repositories as $repository)
                                    <option value="{{ $repository->id }}">
                                        {{ $repository->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Nuovo deposito</label>
                            <select name="new_repo" id="new_repo" class="form-control" required>
                                <option></option>
                                @foreach($repositories as $repository)
                                    <option value="{{ $repository->id }}">
                                        {{ $repository->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Quantità</label>
                            <input type="number" class="form-control" name="quantity">
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button class="btn btn-primary btn-block">Sposta</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#old_repo').selectize();

            $('#new_repo').selectize({
                create: true
            });
        });
    </script>
@endpush