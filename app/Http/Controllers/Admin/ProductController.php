<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Expect;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $products = DB::table('products')->get();
        $products = Product::orderByDesc('id')->paginate(5);
        // dd($products);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = DB::table('categories')->whereNull('deleted_at')->get();
        return view('admin.product.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $slug = str::slug($request->name);
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'image' => $request->image,
            'slug' => $slug,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
            'is_trending' => $request->is_trending,
            'stock_quantity' => $request->stock_quantity
        ];
        // dd($request->all());
        // Lưu trữ hình ảnh sản phẩm chính
        if ($request->hasFile('image')) {
            $fileName = $request->image->getClientOriginalName();
            $request->image->storeAs('public/images', $fileName);
            $data['image'] = $fileName;
        }

        // Tạo sản phẩm bằng Eloquent Model
        $product = Product::create($data);

        // Nếu sản phẩm được tạo thành công và có hình ảnh liên quan
        if ($product && $request->hasFile('images')) {
            foreach ($request->images as $value) {
                $fileName = $value->getClientOriginalName();
                $value->storeAs('public/images', $fileName);
                // Thêm hình ảnh liên quan vào bảng ProductImages
                DB::table('Product_images')->insert([
                    'product_id' => $product->id,
                    'image' => $fileName
                ]);
            }
        }

        return redirect()->route('product.index');
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
        $category = Category::all();
        $products = Product::with('category')->where('id', $id)->first(); // cách 1

        // cách 2:
        // $products = DB::table('products')  
        //     ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        //     ->select('products.*', 'categories.name as category_name')
        //     ->where('products.id', $id)
        //     ->first();

        return view('admin.product.edit', compact('products', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        //
        $product = Product::query()->findOrFail($id);
        // DB::table('products')->findOr($id, function () {
        //     abort('404');
        // });
        if ($request->hasFile('image')) {
            $fileName = $request->image->getClientOriginalName();
            $request->image->storeAs('public/images', $fileName);

            $product->image = $fileName;
        }

        // Lưu lại các thay đổi
        $product->save();

        $data = $request->except(['_method', '_token', 'image', 'images']);
        // Cập nhật hình ảnh liên quan nếu có
        if ($request->hasFile('images')) {
            // Xóa tất cả các hình ảnh liên quan cũ của sản phẩm
            DB::table('Product_images')->where('product_id', $product->id)->delete();

            // Thêm mới các hình ảnh liên quan vào bảng ProductImages
            foreach ($request->images as $image) {
                $fileName = $image->getClientOriginalName();
                $image->storeAs('public/images', $fileName);

                DB::table('Product_images')->insert([
                    'product_id' => $product->id,
                    'image' => $fileName
                ]);
            }
        }
        // dd($data);
        $product->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Product::where('id', $id)->update(['deleted_at' => now()]);
        return back();
    }

    public function trash()
    {

        // $product = Product::whereNotNull('deleted_at')->get();


        $product = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->whereNotNull('products.deleted_at')
            ->get();

        // dd($product);
        return view('admin.product.trash', compact('product'));
    }


    public function restore(string $id)
    {
        Product::where('id', $id)->restore(); // cánh 1
        // DB::table('products')->where('id', $id)->update(['deleted_at' => null]); // cách 2
        return redirect()->back();
    }

    public function permanentlyDelete(string $id)
    {
    }
}
