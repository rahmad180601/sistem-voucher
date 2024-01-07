<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::latest()->get();
        return view('admin.page.produk.index',[
            'produk' => $produk
        ]);
    }

    public function store(Request $request)
    {
        $produks = new Produk;
        $produks->name_produk = $request->get('name_produk');
        $produks->price = $request->get('price');
        $produks->desc = $request->get('desc');

        if($request->hasFile('image')){
            $file= $request->file('image');
            $file->move(public_path().'/image/produk', $file->GetClientOriginalName());
            $produks->image = $file->GetClientOriginalName();
        }
        
        $produks->save();        
        return back();
    }

    public function update(Request $request)
    {
        $produks = Produk::findOrfail($request->id);    
        $produks->name_produk = $request->get('name_produk');
        $produks->price = $request->get('price');
        $produks->desc = $request->get('desc');

        if($request->file('image')==''){
            $file= $request->get('fileku');     
        }else{
            $file= $request->file('image');
            $file->move(public_path().'/image/produk', $file->GetClientOriginalName());            
            $produks->image = $file->GetClientOriginalName();
        }                   

        $produks->update();

        return back();
    }

    public function delete(Request $request)
    {
        $produks = Produk::findOrfail($request->id); 
        if($produks){
            $produks->delete();        
        }
        
        return back();
    }
}
