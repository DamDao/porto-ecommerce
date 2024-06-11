<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $category = Category::where('status', 1)->orWhere('deleted_at', null)->get();
        // dd($category);
        $latestProduct = DB::table('products')->orderBy('created_at', 'DESC')->paginate(3);
        $productTrending = Product::where('is_trending', 1)->get();
        // dd($productTrending);
        return view('clinet.home', compact('productTrending', 'latestProduct', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detail(string $id)
    {
        //
        // $imageThumbnail =

        $product = Product::with('images')->find($id);
       
        // sản phẩm cùng loại
        // dd($product->category_id);
        $related = Product::where('category_id', $product->category_id)
            ->WhereNot('id', $product->id)
            ->get();
        // dd($related);


        return view('clinet.detail', compact('product', 'related'));
    }

    public function searchCategory($id)
    {
        $searchCategory = Product::where('category_id', $id)->get();
        // dd($searchCategory);
        $category = Category::where('status', 1)->get();
        $latestProduct = DB::table('products')->whereIn('id', $searchCategory->pluck('id'))->orderBy('created_at', 'DESC')->paginate(3);
        $productTrending = Product::where('is_trending', 1)->get();
        // dd($productTrending);
        return view('clinet.home', compact('productTrending', 'latestProduct', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login()
    {

        return view('clinet.login');
    }
    public function register()
    {

        return view('clinet.register');
    }

    public function StoreRegister(Request $request)
    {

        //validete

        $request->merge(['password' => Hash::make($request->password)]);
        User::create($request->all());
        // dd($request->all());
        return redirect()->route('login');
    }

    public function InLogin(Request $request)
    {
        //validete
        // dd($request->all());
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('index');
        }
        return redirect()->back()->with('error', 'fail cmnr');
    }

    public function logout(Request $request)
    {
        //validete
        // dd($request->all());
        Auth::logout();
        return redirect()->route('login');
    }
}
