@extends('layouts.front')

@section('content')
    <h2>Muito obrigado por sua compra!</h2>
    <h3>Seu pedido foi processado, código do pedido: {{request()->get('order')}}</h3>

    @if(request()->has('b'))
        <a href="{{request()->get('b')}}" class="btn btn-md btn-info" target="_blank">Imprimir Boleto</a>
    @endif
@endsection
