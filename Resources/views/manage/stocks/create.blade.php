@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuova giacenza</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manager.stocks.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Prodotto</label>
                            <select name="item_id" class="form-control" required>
                                <option></option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Fornitore</label>
                            <select name="supplier_id" class="form-control" required>
                                <option></option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Costo</label>
                            <input type="number" step="0.01" name="price" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Prezzo di vendita</label>
                            <input type="number" step="0.01" name="client_price" class="form-control" required />
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