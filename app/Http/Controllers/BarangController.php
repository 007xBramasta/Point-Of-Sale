<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel as Barang;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BarangController extends Controller
{
    public function index()
    {


        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang'; //set menu yang sedang aktif

        $barangs = $requests = Barang::all();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barangs' => $barangs, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $activeMenu = 'Tambah Barang';
        $breadcrumb = (object) [
            'title' => 'Tambah Data',
            'list' => ['Home', 'Tambah Barang']
        ];
        return view('barang.create', ['activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb]);
    }

    public function store(Request $request)
    {
        
        try{// Validasi request
        $request->validate([
            'image' => 'required|image|max:2048|mimes:png,jpg,jpeg,webp',
            'kategori_id' => 'required',
            'barang_nama' => 'required',
            'harga_beli' => 'required|numeric|lt:harga_jual',
            'harga_jual' => 'required|numeric|gt:harga_beli',
        ]);
        }catch(ValidationException $e){
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = now()->timestamp . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $directory = public_path('images/barang/');
            $image->move($directory, $fileName);
        }

        $barang = Barang::orderBy('barang_kode', 'desc')->first();
        $parts = explode('-', $barang->barang_kode);
        $prefixAndNumber = $parts[0];
        $number = substr($prefixAndNumber, 3); // Get the remaining characters as the number

         // Increment the number part
        $nextNumber = intval($number) + 1;
        $barang_code =  'BRG0'.$nextNumber .' - '.date('dmY');

        // Buat barang baru
        Barang::create([
            'kategori_id' => $request->input('kategori_id'),
            'barang_kode' => $barang_code,
            'barang_nama' => $request->input('barang_nama'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
            'image' => $fileName
        ]);
        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }
    public function edit(string $id)
    {
        $barang = Barang::find($id);
        // Log::info($barang);

        $activeMenu = 'Edit Barang';
        $breadcrumb = (object) [
            'title' => 'Edit Data',
            'list' => ['Home', 'Edit Barang']
        ];

        return view('barang.edit', compact('barang', 'activeMenu', 'breadcrumb'));
    }



    public function update(Request $request, Barang $barang)
    {
        // Validasi request

        $request->validate([
            'image' => 'nullable|image|max:2048|mimes:png,jpg,jpeg,webp',
            'kategori_id' => 'required',
            'barang_kode' => 'required|unique:m_barang,barang_kode,' . $barang->barang_id . ',barang_id',
            'barang_nama' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
        ]);

        // Perbarui barang
        if ($request->hasFile('image')) {
            if (file_exists(public_path('images/products/' . $barang->image))) {
                unlink(public_path('images/products/' . $barang->image));
            }

            $image = $request->file('image');
            $fileName = now()->timestamp . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $directory = public_path('images/barang/');
            $image->move($directory, $fileName);
            $barang->image = $fileName;
        }

        $barang->update([
            'kategori_id' => $request->input('kategori_id'),
            'barang_kode' => $request->input('barang_kode'),
            'barang_nama' => $request->input('barang_nama'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
        ]);

        $barang->save();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }


    public function destroy(Barang $barang)
    {
        try {
            // Hapus barang
            $barang->delete();

            return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil dihapus.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('barang.index')
                    ->with('error', 'Tidak dapat memperbarui barang karena ada data yang terkait.');
            }

            // Jika error bukan karena constraint foreign key, lempar kembali error
            throw $e;
        }
    }
}
