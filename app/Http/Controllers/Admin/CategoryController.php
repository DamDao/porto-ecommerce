<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $keyword = $request->keyword;

        // $categories = DB::table('categories')->where('name', 'like', $keyword)->get();

        // $categories = DB::table('categories')->whereNull('deleted_at')->paginate(5);
        // Tìm kiếm các danh mục dựa trên từ khóa
        $categories = DB::table('categories')
            ->where('name', 'like', "%$keyword%")
            ->orWhere('id', 'like', "%$keyword%")
            ->orWhere('created_at', 'like', "%$keyword%")
            ->whereNull('deleted_at')
            ->paginate(5);
        return view('admin.category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        //

        // dd($request->all());
        $data = [
            'name' => $request->name,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('categories')->insert($data);
        // redirect(view('admin.category.index'));
        return redirect()->route('category.index');
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
        $categories = DB::table('categories')->findOr($id, function () {
            abort('404');
        });
        return view('admin.category.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        //
        $categories = DB::table('categories')->findOr($id, function () {
            abort('404');
        });
        $data = [
            'name' => $request->name,
            'status' => $request->status,
            // 'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('categories')->where('id', $id)->update($data);
        // redirect(view('admin.category.index'));
        return redirect()->route('category.index');
        //    return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // xóa cứng
        // DB::table('categories')->delete($id);
        //end xóa cứng 
        //xóa mền
        $category = Category::where('id', $id)->first();
        // dd($category->status);
        if ($category->status == 0) {
            DB::table('categories')->where('id', $id)
                ->update(['deleted_at' => now()]);
            return redirect()->route('category.trash');
        }
        //end xóa mền
        return Redirect::back()->with('error', 'Vui lòng chuyển sang trạng thái ẩn rồi xóa để ko bị ảnh hưởng tới trải nghiệm người dùng ');
    }

    public function trash()
    {
        $categories = DB::table('categories')->whereNotNull('deleted_at')->paginate(5);
        // dd($categories);
        return view('admin.category.trash', ['categories' => $categories]);
    }

    public function restore(string $id)
    {
        DB::table('categories')->where('id', $id)
            ->update(['deleted_at' => null]);
        return redirect()->route('category.index')->with('success', 'Dữ liệu đã được khôi phục thành công.');
    }

    public function permanentlyDelete(string $id)
    {
        DB::table('categories')->delete($id);
        return redirect()->route('category.index')->with('success', 'Xóa thành công.');
    }

    // public function search(Request $request)
    // {
    //     $keyword = $request->keyword;

    //     $categories = DB::table('categories')->where('name', 'like', $keyword)->get();
    //     // return view('')
    // }
}
