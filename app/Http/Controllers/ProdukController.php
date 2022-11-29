<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all();
        return $produk;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gambar_produk = $request->gambar_produk;
            $gambar = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $gambar_produk));

            //
            $namagambar = "gambar-Produk-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
            $namafile = $namagambar . '.' . 'jpg';
            //rename file name with random number
            $path = public_path('datagambar_produk/');
            //image uploading folder path
            file_put_contents($path . $namafile, $gambar);
            $posting_gambar = 'datagambar_produk/' . $namafile;

        $katproduk = ProdukKategori::where('id', $request->id_kategori)->first();
        $table = Produk::create([
            "nama_produk" => $request->nama_produk,
            "nama_kategori" => $katproduk->nama_kategori,
            "id_kategori" => $request->id_kategori,
            "gambar_produk" => $posting_gambar,
            "deskripsi_produk" => $request->deskripsi_produk,
            "harga_produk" => $request->harga_produk
        ]);

        return response()->json([
            'succes' => 201,
            'message' => 'data berhasil disimpan',
            'data' => $table
        ], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::where('id_kategori', $id)->orderBy('update_at', 'DESC')
        ->get();
        if ($sproduk) {
            return response()->json([
                'status'  => 200,
                'message' => 'Data ditemukan',
                'data'    -> $produk
            ], 200);
        } else {
            return response()->json([
                'status'  => 404,
                'message' => 'id_produk ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }
    public function cariproduk($nama_produk)
    {
        return response()->json([
            'message'  => 'Data yang ditemukan',
            'data' => Produk::orderBy('create_at','DESC')
                 ->where('nama_produk','LIKE','%' . $nama_produk . '%')
                 ->get()
        ], 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id_user);
        if ($user->role == 'admin') {
            $produk = Produk::find($id);
            if ($produk) {
                if ($request->gambar_produk != '') {
                    $gambar_produk = $request->gambar_produk;
                    $gambar = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $gambar_produk));

                    //
                    $nama_gambar = "file-gambar-produk-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
                    $namafile = $nama_gambar . '.' . 'jpg';
                    //rename file name with random number
                    $path = public_path('data_gambar_produk/');
                    //image uploading folder path
                    file_put_contents($path . $namafile, $gambar);

                    // 
                    $posting_gambar = 'data_gambar_produk/' . $namafile;

                    $produk->id_kategori = $request->id_kategori ? $request->id_kategori : $produk->id_kategori;
                    $produk->nama_produk = $request->nama_produk ? $request->nama_produk : $produk->nama_produk;
                    $produk->gambar_produk = $posting_gambar ? $posting_gambar : $produk->gambar_produk;
                    $produk->deskripsi_produk = $deskripsi_produk ? $deskripsi_produk : $produk->deskripsi_produk;
                    $produk->harga_produk_produk = $request->harga_produk_produk ? $request->harga_produk_produk : $produk->harga_produk_produk;
                    $produk->save();
                } else {
                    $produk->id_kategori = $request->id_kategori ? $request->id_kategori : $produk->id_kategori;
                    $produk->nama_produk = $request->nama_produk ? $request->nama_produk : $produk->nama_produk;
                    $produk->gambar_produk = $produk->gambar_produk;
                    $produk->deskripsi_produk = $deskripsi_produk ? $deskripsi_produk : $produk->deskripsi_produk;
                    $produk->harga_produk_produk = $request->harga_produk_produk ? $request->harga_produk_produk : $produk->harga_produk_produk;
                    $produk->save();
                }

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diupdate',
                    'data'      => $produk
                ], 200);
            } else { 
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id produk ' . $id . ' tidak ditemukan'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'maaf anda bukan admin'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id_user);
        if ($user->role == 'admin') {
            $produk = Produk::where('id', $id)->first();
            if ($produk) {
                $produk->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil dihapus',
                    'data'      => $produk
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id produk ' . $id . ' tidak ditemukan'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'maaf anda bukan admin'
            ], 404);
        }
    }
}
