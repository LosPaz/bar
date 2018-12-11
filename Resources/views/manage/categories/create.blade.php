@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuova categoria</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manager.categories.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Sottocategoria</label>
                            <select name="bar_category_id" class="form-control">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button class="btn btn-primary btn-block">Salva</button>
                </div>
            </form>
        </div>
    </div>

@endsection