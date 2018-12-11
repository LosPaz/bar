@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifica categoria</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manager.categories.update', $category->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Sottocategoria</label>
                            <select name="bar_category_id" class="form-control">
                                <option></option>
                                @foreach($categories as $sub)
                                    <option value="{{ $sub->id }}" @if($category->bar_category_id == $sub->id) selected @endif>{{ $sub->name }}</option>
                                @endforeach
                            </select>
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