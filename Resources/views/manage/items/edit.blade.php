@extends('Bar::manage.manage')

@section('manage.content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifica prodotto</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manager.items.update', $item->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ $item->name }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Formato</label>
                            <input type="text" name="format" class="form-control" placeholder="Es. 33cl" value="{{ $item->format }}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Categoria</label>
                            <select name="bar_category_id" class="form-control">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id == $item->category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-label">Vendibile</div>
                            <label class="custom-switch">
                                <input type="checkbox" name="sellable" value="1" class="custom-switch-input"
                                       @if($item->sellable) checked @endif>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Sì</span>
                            </label>
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