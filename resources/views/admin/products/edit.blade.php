@extends('admin.app')

@section('title', 'Edit Produk - Admin')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Produk / Edit {{ $data['product']->name }}</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <h4>
                    <i class="fas fa-edit mr-1"></i>
                    Edit Produk
                    <div class="float-right">
                        <a class="btn btn-secondary btn-sm" href="{{ route('products.index') }}">Back</a>
                    </div>
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('products.update', $data['product']->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="mb-1" for="name">Nama Produk</label>
                        <input class="form-control py-4" id="name" name="name" type="text" placeholder="Masukkan nama produk" value="{{ $data['product']->name }}" required />
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="description">Deskripsi</label>
                        <input class="form-control py-4" id="description" name="description" type="text" placeholder="Masukkan deskripsi produk" value="{{ $data['product']->description }}" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="price">Harga</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input class="form-control py-4" id="price" name="price" type="number" placeholder="Masukkan harga produk" value="{{ $data['product']->price }}" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="category">Kategori: <strong>{{ $data['product']->category->name }}</strong></label>
                                <select class="custom-select" id="category_id" name="category_id" placeholder="Pilih kategori produk" value="{{ $data['product']->category->name }}" required>
                                    <option value="{{ $data['product']->category->id }}" selected><strong>{{ $data['product']->category->name }}</strong></option>
                                    @foreach ($data['categories'] as $category)
                                    @if ($category->name == $data['product']->category->name)
                                    @continue
                                    @endif
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-1" for="file">Upload Gambar Produk</label>
                                <input class="form-control-file" id="file" name="file" type="file" value="{{ $data['product']->file_image }}" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="text-center">
                                <img src="{{ asset('/storage/images/'.$data['product']->file_image) }}" alt="{{ $data['product']->file_image }}" height="150" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection
