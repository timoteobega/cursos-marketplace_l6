@extends('layouts.app')

@section('content')

    <h1>Atualizar Loja</h1>
    <form action=" {{route('admin.stores.update',['store' => $store->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="form-group">
            <div>
                <label>Nome Loja</label>
                <input type="text" name="name" class="form-control" value="{{$store->name}}">
            </div>
            <div>
                <label>Descrição</label>
                <input type="text" name="description" class="form-control" value="{{$store->description}}">
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" name="phone" class="form-control" value="{{$store->phone}}">
            </div>
            <div>
                <label>Celular</label>
                <input type="text" name="mobile_phone" class="form-control" value="{{$store->mobile_phone}}">
            </div>
            <div class="form-group">
                <p>
                    <img src="{{asset('storage/' . $store->logo)}}" alt="">
                </p>
                <label>Logo da loja</label>
                <input name="logo" type="file" class="form-control @error('logo') is-invalid @enderror">
                @error('logo')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
{{--            <div>
                <label>Slug</label>
                <input type="text" name="slug" class="form-control" value="{{$store->slug}}">
            </div>--}}
            <div>
                <button type="submit" class="btn btn-lg btn-success">Atualizar Loja</button>
            </div>
        </div>
    </form>

@endsection
