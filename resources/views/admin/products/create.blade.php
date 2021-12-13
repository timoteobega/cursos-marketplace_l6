@extends('layouts.app')

@section('content')

    <h1>Criar Produto</h1>
    <form action="{{route('admin.products.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <div>
                <label>Nome Produto</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
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
                <label>Conteúdo</label>
                <textarea name="body" id="" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror" value="{{old('body')}}"></textarea>
                @error('body')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div>
                <label>Preço</label>
                <input type="text" name="price" id="price" min="0.01" class="form-control @error('price') is-invalid @enderror" value="{{old('price')}}">
                @error('price')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Categorias</label>
                <select name="categories[]" id="" class="form-control" multiple>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Fotos do Produto</label>
                <input name="photos[]" type="file" class="form-control @error('photos.*') is-invalid @enderror" multiple>
                @error('photos.*')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
{{--            <div>
                <label>Slug</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{old('slug')}}">
                @error('slug')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>--}}
            <div>
                <button type="submit" class="btn btn-lg btn-success">Criar Produto</button>
            </div>
        </div>
    </form>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/plentz/jquery-maskmoney@master/dist/jquery.maskMoney.min.js"></script>
    <script>
        $('#price').maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            thousands: '.',
            decimal: ','
        });
    </script>
@endsection
