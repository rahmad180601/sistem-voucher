<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Voucher;
use App\Models\VoucherCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $data = Produk::take(3)->get();
        return view('welcome',[
            'data' => $data
        ]);
    }

    public function shop(Request $request, $id = null)
    {
        $product = Produk::where('name_produk', 'LIKE', '%'.$request->search.'%')->paginate(6);
        return view('shop.index',[
            'product' => $product,
            'id' => $id
        ]);
    }

    public function show(Request $request, $id)
    {
        $data = Produk::where('id',$id)->first();
        return view('shop.show',[
            'data' => $data
        ]);
    }

    public function cart()
    {
        $carts = Carts::where('user_id',Auth::user()->id)->get();
        return view('cart.index',[
            'carts' => $carts
        ]);
    }

    public function cartstore(Request $request)
    {
        $data = Carts::where('produk_id', $request->produk_id)->first();

        if($data){
            return redirect('/cart')->with('error', 'Barang Sudah Ada Di Cart');
        }

        Carts::create([
            'user_id' => Auth::user()->id,
            'produk_id' => $request->produk_id,
            'qty' => 1,
        ]);

        return redirect()->route('cart')->with('success', 'Barang Berhasil Ditambah');
    }

    public function cartupdate(Request $request, $id)
    {
        Carts::where('id', $id)->update([
            'qty' => $request->quantity
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function cartdelete($id)
    {
        Carts::where('id',$id)->delete();
        return redirect()->route('cart')->with('success', 'Barang Berhasil Didelete');
    }

    public function checkout(Request $request)
    {

        // $user = Auth::user();
        // // $carts = Carts::where('user_id', Auth::user()->id);
        // $carts = Carts::where('user_id', Auth::user()->id)->get()->toArray();
        // // dd($carts);
        // $cartt = $carts->first();

        // $data = $carts->get();
        // // dd($data->count());
        // VoucherCustomer::create([
        //     'user_id' => $user->id,
        //     'voucher_id' => $request->voucher_id,
        //     'cart_id' => $cartt->id,
        // ]);

        // $trans = Transaksi::create([
        //     'user_id' => Auth::user()->id,
        //     'subtotal' => $request->subtotal
        // ]);

        // // foreach ($data as $cart) {
        // //     $trans ->detail()->create([
        // //         'produk_id' => $cart->produk_id,
        // //         'qty' => $cart->qty,
        // //         'total' => $request->input("product_totals.{$cart->id}"),
        // //     ]);
        // // }
        // foreach ($data as $cart) {
        //     $transDetail = $trans->detail()->create([
        //         'produk_id' => $cart->produk_id,
        //         'qty' => $cart->qty,
        //         'total' =>  '0',
        //     ]);
        //     dd($transDetail);
        // }

        // Carts::where('user_id', Auth::user()->id)->delete();


        // return redirect()->route('home');  
        $user = Auth::user();
        $carts = Carts::where('user_id', Auth::user()->id)->get()->toArray();
    
        // Pastikan ada item di keranjang
        if (!empty($carts)) {
            $cartt = reset($carts);
    
            VoucherCustomer::create([
                'user_id' => $user->id,
                'voucher_id' => $request->voucher_id,
                'cart_id' => $cartt['id'],
            ]);
    
            $trans = Transaksi::create([
                'user_id' => Auth::user()->id,
                'subtotal' => $request->subtotal
            ]);
    
            // Iterasi setiap item di keranjang
            foreach ($carts as $cart) {
                // Buat detail transaksi
                $produk = Produk::find($cart['produk_id']);
                if ($produk) {
                    // Buat detail transaksi
                    $trans->detail()->create([
                        'produk_id' => $cart['produk_id'],
                        'qty' => $cart['qty'],
                        'total' => $produk->price * $cart['qty'],
                    ]);
                }
            }
    
            // Hapus item di keranjang setelah checkout
            Carts::where('user_id', Auth::user()->id)->delete();
        }
    
        return redirect()->route('home');

    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $total = $request->get('subtotal');

        // Check if the user has already used this voucher
        $user = Auth::user();
        $voucher = Voucher::where('code', $request->code)
            ->where('expiration_date', '>', now())
            ->first();

        if (!$voucher) {
            return redirect()->back()->with('error', 'CODE VOUCHER TIDAK DITEMUKAN.');
        }

        // Check if the user has already used this voucher
        $hasUsedVoucher = VoucherCustomer::where('user_id', $user->id)
            ->where('voucher_id', $voucher->id)
            ->exists();

        if ($hasUsedVoucher) {
            return redirect()->back()->with('error', 'Anda sudah menggunakan voucher ini sebelumnya.');
        }

        if ($voucher->minimal_belanja >= $total) {
            return redirect()->back()->with('errortotal', 'TOTAL BELANJA TIDAK CUKUP.');
        }

        // Store voucher information in session
        session(['voucher_id' => $voucher->id]);
        session(['voucher_amount' => $voucher->jumlah]);

        return redirect()->back()->with('success', 'Voucher applied successfully.');
    }

}
