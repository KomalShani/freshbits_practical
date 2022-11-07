<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('product.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
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
            'price' => 'required',
            'upc' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        if ($request->hasFile('image')) {
            $img = $this->imageUpload($request, 'image', 'images');
        }

        // Product::create($request->all());

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'upc' => $request->upc,
            'image' => $img         
        ];

        $user = Product::create($data);

        return redirect()->route('product.index')
                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('product.edit',compact('product'));
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
        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'upc' => 'required'
        ]);
        if (($request->image == '') || ($request->hasFile('new_image'))) {
            request()->validate([
                'new_image' => 'required', 'image', 'mimes:jpeg,png,jpg'
            ]);
        }
        if ($request->hasFile('new_image')) {
            $product_img = $this->imageUpload($request, 'new_image', 'images');
            if ($product_img) {
                $imageFile = $request->old_photo;
                $myFile = public_path() . '/images/' . $imageFile;
                File::delete($myFile);
            }
        }
        $product = Product::find($id);
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'upc' => $request->upc,
            'image' => isset($product_img) ? $product_img : $request->image,         
        ];
        
        
        if ($product->update($data)) {
            return redirect()->route('product.index')->with('success', 'Product updated successfully!');
        } else {
            return redirect()->route('product.index')->with('error', 'Something went wrong. Please try again.');
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
        $product = Product::where('id', $id)->delete();

        return redirect()->route('product.index')
                        ->with('success','Product deleted successfully');
    }

    public function productDeleteAll(Request $request)
    {
        $ids = $request->ids;
        $products = Product::whereIn('id',explode(",",$ids))->delete();
        
        return response()->json(['success'=>"Products Deleted successfully."]);
    }

    public function imageUpload($request, $field, $folder) {
        $image = $request->file($field);
        $uploadedPhotoName = time() . rand(0, 9) . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path($folder);
        $image->move($destinationPath, $uploadedPhotoName);
        usleep(300000);
        return $uploadedPhotoName;
    }
}
