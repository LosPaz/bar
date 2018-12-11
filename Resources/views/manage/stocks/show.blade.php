@extends('Bar::manage.manage')

@section('manage.content')

        <h1 class="page-title">
            Giacenze {{ $stock->item->name }}
        </h1>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transazioni</h3>

                    <div class="card-options">
                        <a href="{{ route('manager.stocks.transactions.create', $stock->id) }}" class="btn btn-green btn-sm">
                            <span class="fe fe-plus"></span>
                            Crea transazione
                        </a>
                        &nbsp;
                        <a href="{{ route('manager.stocks.transactions.move', $stock->id) }}" class="btn btn-primary btn-sm">
                            <span class="fe fe-corner-down-right"></span>
                            Sposta da deposito a deposito
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th colspan="2">Utente</th>
                            <th>Deposito</th>
                            <th>Quantità</th>
                            <th colspan="2">Tipo</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td class="w-1"><span class="avatar" style="background-image: url({{ $transaction->user->profilePhoto()}})"></span></td>
                                <td>{{ $transaction->user->fullName() }}</td>
                                <td class="w-1">{{ $transaction->repository->name }}</td>
                                <td>
                                    @if($transaction->type == 0)
                                        +
                                    @else
                                        -
                                    @endif
                                      {{ $transaction->quantity }}
                                </td>
                                <td>
                                    @if($transaction->type == 0)
                                        <span class="tag tag-success">entrata</span>
                                    @else
                                        <span class="tag tag-warning">uscita</span>
                                    @endif
                                </td>
                                <td><i>{{ $transaction->description }}</i></td>
                                <td>{{ $transaction->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="card-footer text-center align-self-center">
                        {{ $transactions->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection