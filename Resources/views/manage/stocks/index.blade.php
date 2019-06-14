@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Giacenze</h3>
            <div class="card-options">
                <a href="{{ route('manager.stocks.create') }}" class="btn btn-green btn-sm">
                    <span class="fe fe-plus"></span>
                    Aggiungi giacenza
                </a>
                &nbsp;
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm"
                               value="{{ request()->q }}"
                               placeholder="Cerca..." name="q">
                        <span class="input-group-btn ml-2">
                            <button class="btn btn-sm btn-default" type="submit">
                              <span class="fe fe-search"></span>
                            </button>
                          </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-striped table-vcenter">
                <thead>
                <tr>
                    <th>Prodotto</th>
                    <th>Formato</th>
                    <th>Fornitore</th>
                    <th>Costo</th>
                    <th>Prezzo di vendita</th>
                    <th>Giacenza</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($stocks as $stock)
                    <tr>

                        <td>{{ $stock->item->name }}</td>
                        <td>{{ $stock->item->format }}</td>
                        <td>
                            {{ $stock->supplier->name }}
                        </td>
                        <td>
                            &euro;{{ $stock->price }}
                        </td>
                        <td>
                            &euro;{{ $stock->client_price }}
                        </td>
                        <td>
                            @foreach($stock->getRepositoryTotal() as $repos)
                                {{ $repos['name'] }} : {{$repos['total']}}
                                <br />
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('manager.stocks.show', $stock->id) }}" class="icon"><i class="fe fe-eye"></i></a>
                            <a href="{{ route('manager.stocks.edit', $stock->id) }}" class="icon"><i class="fe fe-edit"></i></a>
                            <a href="#" class="icon" onclick="if(confirm('Vuoi davvero eliminare questo elemento?')){$('#del-{{ $stock->id }}').submit()}">
                                <i class="text-red fe fe-trash"></i>
                            </a>
                            <form style="visibility: hidden"
                                  method="POST"
                                  id="del-{{ $stock->id }}" action="{{ route('manager.stocks.destroy', $stock->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-footer text-center align-self-center">
                {{ $stocks->appends(request()->all())->links() }}
            </div>
        </div>
    </div>

@endsection