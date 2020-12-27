<?php

namespace App\Http\Controllers;

// Load Function and dependencies on Laravel 7
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

// Load All The Model
use App\Cart;
use App\Categorie;
use App\Customer;
use App\Flower;
use App\Historie;
use App\Transaction;
use App\User;

class ManagerController extends Controller
{
    public function index()
    {
        session(['menu_manager' => 'login']);
        return view('manager.login');
    }

    public function login(Request $request)
    {
        request()->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $email = $request->email;
        $password = $request->password;
        $data = User::where(["email" => $email, "password" => $password])->first();
        if ($data) {
            session(['manager_id' => $data->id]);
            return redirect('/manager-home')->with('alert-login-manager', "Anda berhasil login.");
        } else {
            return redirect('/manager-login')->with('alert-login-manager', "Maaf. Gagal login, mohon periksa username dan password anda.");
        }
    }

    public function home()
    {
        session(['menu_manager' => 'home']);
        return view('manager.home');
    }

    public function create_flower()
    {
        session(['menu_manager' => 'manager_menu']);
        return view('manager.flower_add');
    }

    public function create_flower_store(Request $request)
    {
        request()->validate([
            'categories'    => 'required',
            'flower_name'   => 'required|min:5|unique:flowers,flower_name',
            'flower_price'  => 'required|numeric|gte:5000',
            'description'   => 'required|min:20',
            'file'          => 'required|file|image|mimes:jpeg,png,jpg'
        ]);
        $path = Storage::putFile('public/flower_image', $request->file('file'));
        $explode = explode('/', $path);
        $data = array(
            'categorie_id' => $request->categories,
            'flower_name' => $request->flower_name,
            'flower_price' => $request->flower_price,
            'description' => $request->description,
            'flower_image' => $explode[2]
        );
        Flower::create($data);
        return redirect('/manager-add-flower')->with("alert-add-flower", "Data telah ditambahkan.");
    }

    public function manage_categories()
    {
        session(['menu_manager' => 'manager_menu']);
        return view("manager.manage_categories");
    }

    public function manager_categories_create()
    {
        session(['menu_manager' => 'manager_menu']);
        return view("manager.manage_categories_create");
    }

    public function manager_categories_store(Request $request)
    {
        request()->validate([
            'name'   => 'required|min:5|unique:categories,name',
            'file'   => 'required|file|image|mimes:jpeg,png,jpg'
        ]);
        $path = Storage::putFile('public/flower_categories', $request->file('file'));
        $explode = explode('/', $path);
        $data = array(
            'name' => $request->name,
            'image' => $explode[2]
        );
        Categorie::create($data);
        return redirect('/manager-categories-create')->with("alert-add-categories", "Data telah ditambahkan.");
    }

    public function manager_categories_edit($id)
    {
        session(['menu_manager' => 'manager_menu']);
        $data['categories'] = Categorie::find($id);
        return view("manager.manage_categories_edit", $data);
    }

    public function manager_categories_update(Request $request)
    {
        $id = $request->id;
        if ($request->file) {
            request()->validate([
                'name'   => 'required|min:5|unique:categories,name',
                'file'   => 'file|image|mimes:jpeg,png,jpg'
            ]);
            $path = Storage::putFile('public/flower_categories', $request->file('file'));
            $explode = explode('/', $path);
            $data = array(
                'name' => $request->name,
                'image' => $explode[2]
            );
            Categorie::where(['id' => $id])->update($data);
            $redirect = '/manager-categories-edit/' . $id;
            return redirect($redirect)->with("alert-edit-categories", "Data telah berubah.");
        } else {
            request()->validate([
                'name'   => 'required|min:5|unique:categories,name'
            ]);
            $data = array('name' => $request->name);
            Categorie::where(['id' => $id])->update($data);
            $redirect = '/manager-categories-edit/' . $id;
            return redirect($redirect)->with("alert-edit-categories", "Data telah berubah.");
        }
    }

    public function manager_categories_delete($id)
    {
        $data_categorie = Categorie::find($id);
        $data_flower = Flower::where(['categorie_id' => $id])->get();
        if ($data_flower) {
            foreach ($data_flower as $row) {
                if (file_exists('./storage/flower_image/' . $row->flower_image)) {
                    unlink('./storage/flower_image/' . $row->flower_image);
                }
                Storage::delete('public/flower_image/', $row->flower_image);
                $flower = Flower::find($row->id);
                $flower->delete();
            }
        }
        if (file_exists('./storage/flower_categories/' . $data_categorie->image)) {
            unlink('./storage/flower_categories/' . $data_categorie->image);
        }
        Storage::delete('public/flower_categories/', $data_categorie->image);
        $data_categorie->delete();
        return redirect('manager-categories')->with("alert-delete-categories", "Data telah dihapus.");
    }

    public function change_pass()
    {
        session(['menu_manager' => 'manager_menu']);
        return view("manager.change_password");
    }

    public function change_pass_manager(Request $request)
    {
        request()->validate([
            'password_now'          => 'required|min:8',
            'password_new'          => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password_new'
        ]);
        $manager_id = session('manager_id');
        $data = array('password' => $request->password_new);
        User::where(['id' => $manager_id])->update($data);
        return redirect('/manager-change-password')->with('alert-change-password-manager', "Anda berhasil mengubah password.");
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/')->with('alert-login', "Anda berhasil logout.");
    }

    public function categories_all($id)
    {
        session(['menu_manager' => 'categories']);
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
        return view("manager.categories", $data);
    }

    public function categories_produk($id)
    {
        session(['menu_manager' => 'categories']);
        $data['flower'] = Flower::find($id);
        return view("manager.categories_produk", $data);
    }

    public function categories_product_update(Request $request)
    {
        $id = $request->id;
        if ($request->file) {
            request()->validate([
                'categories'    => 'required',
                'flower_name'   => 'required|min:5|unique:flowers,flower_name',
                'flower_price'  => 'required|numeric|gte:5000',
                'description'   => 'required|min:20',
                'file'          => 'file|image|mimes:jpeg,png,jpg'
            ]);
            $path = Storage::putFile('public/flower_image', $request->file('file'));
            $explode = explode('/', $path);
            $data = array(
                'categorie_id' => $request->categories,
                'flower_name' => $request->flower_name,
                'flower_price' => $request->flower_price,
                'description' => $request->description,
                'flower_image' => $explode[2]
            );
            Flower::where(['id' => $id])->update($data);
            return redirect('/manager-categories-product-edit/' . $id)->with("alert-edit-product", "Data telah berubah.");
        } else {
            request()->validate([
                'categories'    => 'required',
                'flower_name'   => 'required|min:5|unique:flowers,flower_name',
                'flower_price'  => 'required|numeric|gte:5000',
                'description'   => 'required|min:20'
            ]);
            $data = array(
                'categorie_id' => $request->categories,
                'flower_name' => $request->flower_name,
                'flower_price' => $request->flower_price,
                'description' => $request->description
            );
            Flower::where(['id' => $id])->update($data);
            return redirect('/manager-categories-product-edit/' . $id)->with("alert-edit-product", "Data telah berubah.");
        }
    }

    public function categories_product_delete($id)
    {
        $flower = Flower::find($id);
        $categorie_id = $flower->categorie_id;
        if (file_exists('./storage/flower_image/' . $id)) {
            unlink('./storage/flower_image/' . $id);
        }
        Storage::delete('public/flower_image/', $id);
        $flower->delete();
        return redirect('manager-categories-product/' . $categorie_id)->with("alert-delete-product", "Data telah dihapus.");
    }
}
