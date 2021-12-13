@extends('layouts.app')

@section('content')

    <h1>Criar Loja</h1>
    <form action="{{route('admin.stores.store')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <div>
                <label>Nome da loja</label>
                <input type="text" title="Nome da loja" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
            <div>
                <label>Descrição</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}">
                @error('description')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}">
                @error('phone')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="mobile_phone" name="mobile_phone" class="form-control @error('mobile_phone') is-invalid @enderror" value="{{old('mobile_phone')}}">
                @error('mobile_phone')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Logo da loja</label>
                <input name="logo" type="file" class="form-control @error('logo') is-invalid @enderror">
                @error('logo')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
{{--            <div>
                <label>Slug</label>
                <input type="text" name="slug" class="form-control">
            </div>
            <div>
                <label>Usuário</label>
                <select name="user" class="form-control">
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>--}}
            <div>
                <button type="submit" class="btn btn-lg btn-success">Criar Loja</button>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
    <script>
        let imPhone = new Inputmask('(99) 9999-9999');
        imPhone.mask(document.getElementById('phone'));

        let imMobilePhone = new Inputmask('(99) 9.9999-9999');
        imMobilePhone.mask(document.getElementById('mobile_phone'));
    </script>
@endsection
