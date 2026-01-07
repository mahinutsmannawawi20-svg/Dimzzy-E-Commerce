@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Product</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to List</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                @error('nama_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Price (Rp)</label>
                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $product->harga) }}" required>
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image</label>
                @if($product->foto)
                    <div class="mb-2">
                        <img src="{{ asset($product->foto) }}" alt="Current Image" class="img-thumbnail" style="height: 100px;">
                        <small class="d-block text-muted">Current Image</small>
                    </div>
                @endif
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                <div class="form-text">Leave empty to keep current image</div>
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
