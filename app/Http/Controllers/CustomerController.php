<?php

namespace App\Http\Controllers;

// Load Function and dependencies on Laravel 7
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Load All The Model
use App\Cart;
use App\Categorie;
use App\Customer;
use App\Flower;
use App\Historie;
use App\Transaction;
use App\User;

class CustomerController extends Controller
{
    public function index()
    {
        session(['menu_customer' => 'home']);
        return view("customer.home");
    }

    public function register(Request $request)
    {
        request()->validate([
            'username'              => 'required|min:5',
            'email'                 => 'required|email|unique:customers,email',
            'password'              => 'required|min:8',
            'confirmation_password' => 'required|min:8|same:password',
            'gender'                => 'required',
            'birthday'              => 'required',
            'address'               => 'required|min:10',
        ]);

        $data = array(
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'address' => $request->address
        );
        Customer::create($data);
        return redirect('customer-register')->with('alert-register', 'Akun telah tersimpan, silahkan login.');
    }

    public function login(Request $request)
    {
        request()->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $email = $request->email;
        $password = $request->password;
        $data = Customer::where(["email" => $email, "password" => $password])->first();
        if ($data) {
            session(['customer_id' => $data->id]);
            return redirect('/')->with('alert-login', "Anda berhasil login.");
        } else {
            return redirect('/customer-login')->with('alert-login', "Maaf. Gagal login, mohon periksa username dan password anda.");
        }
    }

    public function change_pass()
    {
        session(['menu_customer' => 'user_menu']);
        return view("customer.change_password");
    }

    public function change_pass_customer(Request $request)
    {
        request()->validate([
            'password_now'          => 'required|min:8',
            'password_new'          => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password_new'
        ]);
        $customer_id = session('customer_id');
        $data = array('password' => $request->password_new);
        Customer::where(['id' => $customer_id])->update($data);
        return redirect('/customer-change-password')->with('alert-change-password', "Anda berhasil mengubah password.");
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/')->with('alert-login', "Anda berhasil logout.");
    }

    public function categories($id, Request $request)
    {
        session(['menu_customer' => 'categories']);
        $data['filter_name'] = "";
        $data['filter_price'] = "";
        $data['categories'] = Categorie::find($id);
        $data['jumlah_produk'] = Flower::where(['categorie_id' => $id])->count();
        if (request()->filter) {
            if (request()->filter == 1) {
                // Search by name
                if (request()->filter_name == "") {
                    $data['product'] = Flower::where(['categorie_id' => $id])->paginate(8);
                } else {
                    $data['product'] = Flower::where([
                        ['categorie_id', '=', $id],
                        ['flower_name', 'like', '%' . request()->filter_name . '%']
                    ])->get();
                    $data['filter_name'] = request()->filter_name;
                }
            } else {
                // Search by price
                $data['filter_price'] = request()->filter_price;
                if (request()->filter_price == '1') {
                    $data['product'] = DB::table('flowers')->where('categorie_id', $id)->orderBy('flower_price', 'asc')->get();
                } else {
                    $data['product'] = DB::table('flowers')->where('categorie_id', $id)->orderBy('flower_price', 'desc')->get();
                }
            }
        } else {
            $data['product'] = Flower::where(['categorie_id' => $id])->paginate(8);
        }
        return view("customer.categories", $data);
    }

    public function categories_product($id)
    {
        session(['menu_customer' => 'categories']);
        $data['flower'] = Flower::find($id);
        return view("customer.categories_produk", $data);
    }

    public function categories_product_add_cart(Request $request)
    {
        $customer_id = session('customer_id');
        request()->validate([
            'qty' => 'required|numeric|min:1'
        ]);
        $flower = Flower::find($request->id);
        $total = $request->qty * $flower->flower_price;
        $data = array(
            'customer_id' => $customer_id,
            'flower_id'   => $request->id,
            'qty'         => $request->qty,
            'total_price' => $total
        );
        Cart::create($data);
        return redirect('/categories-product/' . $flower->id)->with('alert-detail-product', "Berhasil menambah ke Cart.");
    }

    public function my_cart()
    {
        session(['menu_customer' => 'user_menu']);
        $data['cart'] = Cart::where(['customer_id' => session('customer_id')])->get();
        $data['jumlah_cart'] = Cart::where(['customer_id' => session('customer_id')])->count();
        return view("customer.my_cart", $data);
    }

    public function my_cart_update($id, $qty, Request $request)
    {
        $data_cart = Cart::find($id);
        if ($qty == 0) {
            $data_cart->delete();
        } else {
            $aaa = $data_cart->flower->flower_price * $qty;
            $data = array(
                'qty' => $qty,
                'total_price' => $aaa
            );
            $data['cart'] = Cart::where(['id' => $id])->update($data);
        }
        $request->session()->flash('alert-cart', 'Cart berhasil di ubah');
    }

    public function my_cart_checkout(Request $request)
    {
        // Insert to transaction
        $customer_id = session('customer_id');
        $data = new Transaction;
        $data->customer_id = $customer_id;
        $data->save();
        $last_id = $data->id;

        //Get Cart First
        $cart = Cart::where(['customer_id' => $customer_id])->get();
        foreach ($cart as $row) {
            // input them to histories
            $data = array(
                'transaction_id' => $last_id,
                'flower_id' => $row->flower_id,
                'qty' => $row->qty,
                'total_price' => $row->total_price
            );
            Historie::create($data);
        }

        //Then delete cart data
        Cart::where(['customer_id' => $customer_id])->delete();

        //finally redirect it to cart again to inform if checkout was succesful
        return redirect('my-cart')->with('alert-cart', 'Proses Checkout Berhasil');
    }

    public function history_transaction()
    {
        session(['menu_customer' => 'user_menu']);
        $data['transaction'] = Transaction::where(['customer_id' => session('customer_id')])->get();
        return view("customer.history_transaction", $data);
    }

    public function history_transaction_detail($id)
    {
        session(['menu_customer' => 'user_menu']);
        $data['transaction_detail'] = Transaction::find($id);
        $data['transaction'] = Historie::where(['transaction_id' => $id])->get();
        return view("customer.history_transaction_detail", $data);
    }
}
