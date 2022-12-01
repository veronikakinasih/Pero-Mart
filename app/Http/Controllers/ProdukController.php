<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukKategori;
use App\Models\User;
use Illuminate\Http\Request;

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
            $namagambar = "gambar-produk-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
            $filename = $namagambar . '.' . 'jpg';
            //rename file name with random number
            $path = public_path('datagambarproduk/');
            //image uploading folder path
            file_put_contents($path . $filename, $gambar);
            $postgambar = 'datagambarproduk/' . $filename;

            $katproduk = ProdukKategori::where('id', $request->id_kategori)->first();
            $table = Produk::create([
            "nama_produk" => $request->nama_produk,
            "id_kategori" => $request->id_kategori,
            "deskripsi_produk" => $request->deskripsi_produk,
            "gambar_produk" => $postgambar,
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
        $produk = Produk::where('id_kategori', $id)->orderBy('updated_at', 'DESC')
        ->get();
        if ($produk) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $produk
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id produk ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }
    public function searchproduk($nama_produk)
    {
        return response()->json([
            'message' => 'Data yang ditemukan',
            'data' => Produk::orderBy('created_at', 'DESC')
                ->where('nama_produk', 'LIKE', '%' . $nama_produk . '%')
                ->get()
        ], 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbyid($id)
    {
        $produk = Produk::where('id', $id)->orderBy('updated_at', 'DESC')
        ->get();
        if ($produk) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $produk
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id produk ' . $id . ' tidak ditemukan'
            ], 404);
        }
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
        $produk = Produk::find($id);
        if ($produk) {
            if ($request->gambar_produk != '') {
            $gambar_produk = $request->gambar_produk;
            $gambar = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $gambar_produk));

            //
            $namagambar = "gambar-produk-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
            $filename = $namagambar . '.' . 'jpg';
            //rename file name with random number
            $path = public_path('datagambarproduk/');
            //image uploading folder path
            file_put_contents($path . $filename, $gambar);
            $postgambar = 'datagambarproduk/' . $filename;

            $katproduk = ProdukKategori::where('id', $request->id_kategori)->first();
            $table = Produk::create([
            "nama_produk" => $request->nama_produk,
            "id_kategori" => $request->id_kategori,
            "deskripsi_produk" => $request->deskripsi_produk,
            "gambar_produk" => $postgambar,
            "harga_produk" => $request->harga_produk
        ]);
                $produk->id_kategori = $request->id_kategori ? $request->id_kategori : $produk->id_kategori;
                $produk->nama_produk = $request->nama_produk ? $request->nama_produk : $produk->nama_produk;
                $produk->gambar_produk = $postgambar ? $postgambar : $produk->gambar_produk;
                $produk->deskripsi_produk = $request->deskripsi_produk ? $request->deskripsi_produk : $produk->deskripsi_produk;
                $produk->harga_produk = $request->harga_produk ? $request->harga_produk : $produk->harga_produk;
                $produk->save();
                } else {
                $produk->id_kategori = $request->id_kategori ? $request->id_kategori : $produk->id_kategori;
                $produk->nama_produk = $request->nama_produk ? $request->nama_produk : $produk->nama_produk;
                $produk->image_produk = $produk->image_produk;
                $produk->deskripsi_produk = $request->deskripsi_produk ? $request->deskripsi_produk : $produk->deskripsi_produk;
                $produk->harga_produk = $request->harga_produk ? $request->harga_produk : $produk->harga_produk;
                $produk->save();
                }

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil di update',
                    'data'      => $produk
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id produk ' . $id . ' tidak ditemukan'
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
    }
}