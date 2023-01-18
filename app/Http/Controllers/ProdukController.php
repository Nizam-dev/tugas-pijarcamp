<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\produk;

class ProdukController extends Controller
{

    public function index()
    {
        try {
            $produk = produk::orderBy('id','DESC')->get();
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','data'=>null], 500);
        }

        return response()->json(['status'=>'success','data'=>$produk], 200);

    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_produk'=>'required',
            'keterangan'=>'required',
            'harga'=>'required',
            'jumlah'=>'required',
        ]);

        try {
            $produk = produk::create($data);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','data'=>null], 500);
        }
        return response()->json(['status'=>'success','data'=>$produk], 200);
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_produk'=>'required',
            'keterangan'=>'required',
            'harga'=>'required',
            'jumlah'=>'required',
        ]);

        try {
            $produk = produk::find($id)->update($data);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','data'=>null], 500);
        }
        return response()->json(['status'=>'success','data'=>$produk], 200);
    }


    public function destroy($id)
    {
        try {
            $produk = produk::findOrFail($id)->delete();
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','data'=>null], 500);
        }
        return response()->json(['status'=>'success','data'=>$produk], 200);
    }
}
