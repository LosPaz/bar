@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuova transazione</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manager.stocks.transactions.store', $stock->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Prodotto</label>
                            <input type="text" class="form-control" value="{{ $stock->item->name }}" disabled />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Fornitore</label>
                            <input type="text" class="form-control" value="{{ $stock->supplier->name }}" disabled />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Deposito</label>
                            <select name="repository_id" id="repository_id" class="form-control" required>
                                <option></option>
                                @foreach($repositories as $repository)
                                    <option value="{{ $repository->id }}">
                                        {{ $repository->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-label">Tipo transazione</div>
                            <div class="custom-switches-stacked">
                                <label class="custom-switch">
                                    <input type="radio" name="type" value="0" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Entrata</span>
                                </label>
                                <label class="custom-switch">
                                    <input type="radio" name="type" value="1" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Uscita</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Quantità</label>
                            <input type="number" class="form-control" name="quantity" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Descrizione (opzionale)</label>
                            <input type="text" class="form-control" name="description" />
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

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#repository_id').selectize({
                create: true
            });
        });
    </script>
@endpush