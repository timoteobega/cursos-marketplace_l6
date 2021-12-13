@extends('layouts.front')

@section('content')
    <a style="margin-bottom: 10px" href="{{route('admin.notifications.read.all')}}" class="btn btn-sm btn-info">Marcar todas como lida</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Notificação</th>
            <th>Criado em</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse($unreadNotifications as $n)
            <tr>
                <td>{{$n->data['message']}}</td>
                {{--<td>{{$n->created_at->format('d/m/Y H:i:s')}}</td>--}}
                <td>{{$n->created_at->locale('pt')->diffForHumans()}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.notifications.read', ['notification' => $n->id])}}" class="bt btn-sm btn-primary">Marcar como lida</a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">
                    <div class="alert alert-warning">Nenhuma notificação</div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection
