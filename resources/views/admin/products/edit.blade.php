@extends('layouts.app')

@section('content')

    <h1>Atualizar Produto</h1>
    <form action="{{route('admin.products.update',['product' => $product->id])}}" method="post" enctype="multipart/form-data">
        <!-- <input type="hidden" name="_token" value="{{csrf_token()}}"> -->
        <!-- <input type="hidden" name="_method" value="PUT"> -->
            @csrf
            @method("PUT")
        <div class="form-group">
            <div>
                <label>Nome Produto</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$product->name}}">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div>
                <label>Descrição</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{$product->description}}">
                @error('description')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div>
                <label>Conteúdo</label>
                <textarea name="body" id="" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror">{{$product->body}}</textarea>
                @error('body')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div>
                <label>Preço</label>
                <input type="text" name="price" id="price" min="0.01" class="form-control @error('price') is-invalid @enderror" value="{{$product->price}}">
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
                        <option value="{{$category->id}}"
                            @if($product->categories->contains($category)) selected @endif
                        >{{$category->name}}</option>
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
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{$product->slug}}">
                @error('slug')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>--}}
            <div>
                <button type="submit" class="btn btn-lg btn-success">Atualizar Produto</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($product->photos as $photo)
            <div class="col-4 text-center">
                <form action="{{route('admin.photo.remove')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                    <input type="hidden" name="photoName" value="{{$photo->image}}">
                </form>
                <img src="{{asset('storage/' . $photo->image)}}" alt="" class="img-fluid">
            </div>
        @endforeach
    </div>

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

