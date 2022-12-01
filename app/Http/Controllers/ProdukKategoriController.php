<?php

namespace App\Http\Controllers;

use App\Models\ProdukKategori;
use App\Models\User;
use Illuminate\Http\Request;

class ProdukKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $katproduk = ProdukKategori::all();
        return $katproduk;
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
        $katproduk = new ProdukKategori();
            $katproduk->nama_kategori = $request->input('nama_kategori');
            $katproduk->save();

            return response()->json([
                'success'   => 201,
                'message'   => 'data berhasil disimpan',
                'data'      => $katproduk
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
        $katproduk = ProdukKategori::find($id);
        if ($katproduk) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $katproduk
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id kategori produk ' . $id . ' tidak ditemukan'
            ], 404);
        }
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
        $katproduk = ProdukKategori::find($id);
            if ($katproduk) {
                $katproduk->nama_kategori = $request->nama_kategori ? $request->nama_kategori : $katproduk->nama_kategori;
                $katproduk->save();

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diupdate',
                    'data'      => $katproduk
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id kategori produk ' . $id . ' tidak ditemukan'
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
        $katproduk = ProdukKategori::where('id', $id)->first();
            if ($katproduk) {
                $katproduk->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil dihapus',
                    'data'      => $katproduk
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id kategori produk ' . $id . ' tidak ditemukan'
                ], 404);
            }
    }
}