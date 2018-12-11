@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Categorie</h3>
            <div class="card-options">
                <a href="{{ route('manager.categories.create') }}" class="btn btn-green btn-sm">
                    <span class="fe fe-plus"></span>
                    Aggiungi categoria
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
                    <th>Nome</th>
                    <th>Sottocategoria</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>

                        <td>{{ $category->name }}</td>
                        <td>
                            @if($category->subcategory == null)
                                nessuna
                            @else
                                <span class="tag tag-primary">{{ $category->subcategory->name }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('manager.categories.edit', $category->id) }}" class="icon"><i class="fe fe-edit"></i></a>
                            <a href="#" class="icon" onclick="if(confirm('Vuoi davvero eliminare questo elemento?')){$('#del-{{ $category->id }}').submit()}">
                                <i class="text-red fe fe-trash"></i>
                            </a>
                            <form style="visibility: hidden"
                                  method="POST"
                                  id="del-{{ $category->id }}" action="{{ route('manager.categories.destroy', $category->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-footer text-center align-self-center">
                {{ $categories->appends(request()->all())->links() }}
            </div>
        </div>
    </div>

@endsection