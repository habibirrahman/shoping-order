@extends('admin.app')

@section('title', 'Edit Kategori - Admin')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kategori / Edit {{ $category->name }}</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <h4>
                    <i class="fas fa-edit mr-1"></i>
                    Edit Kategori
                    <div class="float-right">
                        <a class="btn btn-secondary btn-sm" href="{{ route('categories.index') }}">Back</a>
                    </div>
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="mb-1" for="name">Nama Kategori</label>
                        <input class="form-control py-4" id="name" name="name" type="text" placeholder="Masukkan nama kategori" value="{{ $category->name }}" required />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" name="submit" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection
