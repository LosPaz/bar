@extends('Bar::manage.manage')

@section('manage.content')

    <h1 class="page-title">
        Turni
    </h1>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Turni</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th colspan="2">Utente</th>
                            <th>Tipo</th>
                            <th>Totale stimato in cassa</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($workshifts as $workshift)
                            <tr>
                                <td class="w-1"><span class="avatar" style="background-image: url({{ $workshift->user->profilePhoto()}})"></span></td>
                                <td>{{ $workshift->user->fullName() }}</td>
                                <td>
                                    @if($workshift->type == 0)
                                        <span class="tag tag-success">apertura</span>
                                    @else
                                        <span class="tag tag-warning">chiusura</span>
                                    @endif
                                </td>
                                <td>
                                    @if($workshift->estimate_amount != null)
                                        &euro;{{ $workshift->estimate_amount }}
                                    @endif
                                </td>
                                <td>{{ $workshift->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="card-footer text-center align-self-center">
                        {{ $workshifts->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection