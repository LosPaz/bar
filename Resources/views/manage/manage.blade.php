@extends('Bar::layouts.bar')

@section('content')
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header">Menù</div>
                <div class="list-group list-group-transparent mb-0">

                    <a href="{{ route('manager.settings.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('manager.settings.*')) active @endif">
                        <span class="icon mr-3"><i class="fe fe-settings"></i></span>Impostazioni
                    </a>

                    <a href="{{ route('manager.history.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('manager.history.*')) active @endif">
                        <span class="icon mr-3"><i class="fe fe-clock"></i></span>Cronologia
                    </a>

                    <a href="{{ route('manager.workshifts.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('manager.workshifts.*')) active @endif">
                        <span class="icon mr-3"><i class="fe fe-users"></i></span>Turni
                    </a>

                    <a href="{{ route('manager.stocks.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('manager.stocks.*')) active @endif">
                        <span class="icon mr-3"><i class="fe fe-package"></i></span>Giacenze
                    </a>

                    <a href="{{ route('manager.items.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('manager.items.*')) active @endif">
                        <span class="icon mr-3"><i class="fe fe-tag"></i></span>Prodotti
                    </a>

                    <a href="{{ route('manager.suppliers.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('manager.suppliers.*')) active @endif">
                        <span class="icon mr-3"><i class="fe fe-users"></i></span>Fornitori
                    </a>

                    <a href="{{ route('manager.categories.index') }}"
                       class="list-group-item list-group-item-action @if(Route::is('manager.categories.*')) active @endif">
                        <span class="icon mr-3"><i class="fe fe-list"></i></span>Categorie
                    </a>
                </div>

            </div>
        </div>
        <div class="col-lg-9">
            @yield('manage.content')
        </div>
    </div>
@endsection