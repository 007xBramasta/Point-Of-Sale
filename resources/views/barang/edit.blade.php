@extends('layouts.template')

{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('barang.update', $barang->barang_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group ">
                <label for="kategori_id">Gambar</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="image"
                        accept="image/png, image/gif, image/jpeg">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <div>
                <p class="text-danger mb-0">Foto produk saat ini!</p>
                <img src="{{asset('images/barang/' . $barang->image)}}" class="img-fluid mb-2" width="200"
                    alt="{{$barang->barang_kode}}">
            </div>
            <div class="form-group">
                <label for="kategori_id">Kategori ID:</label>
                <input type="text" class="form-control" id="kategori_id" name="kategori_id"
                    value="{{ $barang->kategori_id }}">
            </div>
            <div class="form-group">
                <label for="barang_kode">Barang Kode:</label>
                <input type="text" class="form-control" id="barang_kode" name="barang_kode"
                    value="{{ $barang->barang_kode }}">
            </div>
            <div class="form-group">
                <label for="barang_nama">Nama Barang:</label>
                <input type="text" class="form-control" id="barang_nama" name="barang_nama"
                    value="{{ $barang->barang_nama }}">
            </div>
            <div class="form-group">
                <label for="harga_beli">Harga Beli:</label>
                <input type="text" class="form-control" id="harga_beli" name="harga_beli"
                    value="{{ $barang->harga_beli }}">
            </div>
            <div class="form-group">
                <label for="harga_jual">Harga Jual:</label>
                <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                    value="{{ $barang->harga_jual }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
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