<?php

namespace App\Http\Controllers\Admin;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    public function index()
    {
        $voucher = Voucher::latest()->get();
        return view('admin.page.voucher.index',[
            'voucher' => $voucher
        ]);
    }

    public function store(Request $request)
    {
        $vouchers = new Voucher;
        $vouchers->code = $request->get('code');
        $vouchers->jumlah = $request->get('jumlah');
        $vouchers->expiration_date = $request->get('expiration_date');
        $vouchers->minimal_belanja = $request->get('minimal_belanja');
        $vouchers->save();        
        return back();
    }

    public function update(Request $request)
    {
        $vouchers = Voucher::findOrfail($request->id);    
        $vouchers->code = $request->get('code');
        $vouchers->jumlah = $request->get('jumlah');
        $vouchers->expiration_date = $request->get('expiration_date');
        $vouchers->minimal_belanja = $request->get('minimal_belanja');
        
        $vouchers->update();

        return back();
    }

    public function delete(Request $request)
    {
        $vouchers = Voucher::findOrfail($request->id); 
        if($vouchers){
            $vouchers->delete();        
        }
        return back();
    }
}
