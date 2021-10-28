<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    public function showPage(Product $product)
    {
        return view('product', ['data' => $product->all()]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $product->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'imgUrl' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required',

        ]);

        $imageName = time() . '.' . request()->imgUrl->getClientOriginalExtension();

        request()->imgUrl->move(public_path('images'), $imageName);

        Product::create([
            'name' => $request->name,
            'imgUrl'  => $imageName,
            'price' => $request->price,
        ]);

        // return back()
        //     ->with('success', 'You have successfully upload image.')
        //     ->with('image', $imageName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
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

        if ($request->hasFile('imgUrl')) { //意圖上傳新圖片
            request()->validate([
                'name' => 'required',
                'imgUrl' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'price' => 'required',

            ]);

            $imageName = time() . '.' . request()->imgUrl->getClientOriginalExtension();

            request()->imgUrl->move(public_path('images'), $imageName);

            Product::find($id)->update([
                'name' => $request->name,
                'imgUrl'  => $imageName,
                'price' => $request->price,
            ]);
            return "是檔案";
        } else if ($request->imgUrl != 'undefined' && $request->imgUrl != '') { //使用既有圖片
            request()->validate([
                'name' => 'required',
                'imgUrl' => 'required',
                'price' => 'required',

            ]);
            Product::find($id)->update($request->all());

            return "不是檔案";
        } else { //不動圖片
            request()->validate([
                'name' => 'required',
                'price' => 'required',

            ]);
            Product::find($id)->update([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            return "不是檔案";
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
        $fileName = Product::find($id)->imgUrl;


        if (File::exists("images/" . $fileName)) {
            File::delete("images/" . $fileName);
        }

        Product::destroy($id);
    }
}
