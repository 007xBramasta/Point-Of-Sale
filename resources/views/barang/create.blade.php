@extends('layouts.template')

{{-- Customize layout sections --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Level')

{{-- Content --}}

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="kategori_id">Gambar</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="image" accept="image/png, image/gif, image/jpeg">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <div class="form-group">
                <label for="kategori_id">Kategori ID:</label>
                <input type="text" class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" value="{{ old('kategori_id') }}">
                @error('kategori_id')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="barang_nama">Nama Barang:</label>
                <input type="text" class="form-control @error('barang_nama') is-invalid @enderror" id="barang_nama" name="barang_nama" value="{{ old('barang_nama') }}">
                @error('barang_nama')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga_beli">Harga Beli:</label>
                <input type="text" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" value="{{ old('harga_beli') }}">
                @error('harga_beli')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga_jual">Harga Jual:</label>
                <input type="text" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}">
                @error('harga_jual')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.getElementById('inputGroupFile01');
            var label = input.nextElementSibling;

            input.addEventListener('change', function (e) {
                var fileName = '';
                if (this.files && this.files.length > 1) {
                    fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                } else if (this.files.length === 1) {
                    fileName = this.files[0].name;
                }

                if (fileName) {
                    label.textContent = fileName;
                } else {
                    label.textContent = 'Choose file';
                }
            });
        });
    </script>

@endpush