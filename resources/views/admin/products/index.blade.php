@extends('layouts.front')

@section('content')
    <a href="{{route('admin.products.create')}}" class="btn btn-md btn-info">Criar Produto</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Loja</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $p)
            <tr>
                <td>{{$p->id}}</td>
                <td>{{$p->name}}</td>
                <td>R$ {{number_format($p->price,2,',','.')}}</td>
                <td>{{$p->store->name}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.products.edit',['product' => $p->id])}}" class="bt btn-sm btn-primary">Editar</a>
                        <form action="{{route('admin.products.destroy',['product' => $p->id])}}" method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="bt btn-sm btn-danger">Remover</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$products->links()}}

@endsection
