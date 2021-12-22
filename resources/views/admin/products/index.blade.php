@extends('admin.app')

@section('title', 'Produk De Tasty - Admin')

@section('user')
Admin {{ $data['user']->name }}
@endsection

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Produk</li>
        </ol>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <h4>
                    <i class="fas fa-plus-square mr-1"></i>
                    Menambahkan Produk Baru
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="mb-1" for="name">Nama Produk</label>
                        <input class="form-control py-4" id="name" name="name" type="text" placeholder="Masukkan nama produk" required />
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="description">Deskripsi</label>
                        <input class="form-control py-4" id="description" name="description" type="text" placeholder="Masukkan deskripsi produk" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="price">Harga</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input class="form-control py-4" id="price" name="price" type="number" placeholder="Masukkan harga produk" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="category">Kategori</label>
                                <select class="custom-select" id="category_id" name="category_id" placeholder="Pilih kategori produk" required>
                                    <option selected disabled value="1">Pilihlah ...</option>
                                    @foreach ($data['categories'] as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="file">Upload Gambar Produk</label>
                                <input class="form-control-file" id="file" name="file" type="file" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-table mr-1"></i>Data Produk</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($data['products'] as $product)
                            <tr>
                                <td>{{ $product->name }} </td>
                                <td>
                                    <img src="{{ asset('/uploads/'.$product->file_image) }}" alt="{{ $product->file_image }}" width="120" />
                                </td>
                                <td>{{ $product->description }}</td>
                                @php ($p = number_format($product->price))
                                <td class="text-right"><strong>{{ $p }}</strong></td>
                                @if ($product->category_id > 0)
                                <td>{{ $product->category->name }}</td>
                                @else
                                <td>-</td>
                                @endif
                                <td class="text-center">
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        <a title="Edit" class="btn btn-warning btn-sm m-1" href="{{ route('products.edit', $product->id) }}">edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete" type="submit" class="btn btn-danger btn-sm m-1" onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}?')">delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
