@extends('Bar::manage.manage')

@section('manage.content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cronologia delle transazioni</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th colspan="2">Utente</th>
                            <th>Prodotto</th>
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
                                <td>{{ $transaction->stock->item->name }} ({{ $transaction->stock->item->format }})</td>
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