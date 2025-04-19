<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'ASC')->paginate(10);
        return view('admin.brands',compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.add-brand');
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->GenerateBrandThumbnailIsImage($image,$file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status','Brand added successfully');
    }

    public function edit_brand($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.edit-brand',compact('brand'));
    }


    public function update_brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$request->id,
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = Brand::findOrFail($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if(File::exists(public_path('uploads/brands/').'/'.$brand->image))
            {
                 File::delete(public_path('uploads/brands/').'/'.$brand->image);
            }
            if(File::exists(public_path('uploads/brands/thumbnail/').'/'.$brand->image))
            {
                 File::delete(public_path('uploads/brands/thumbnail/').'/'.$brand->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->GenerateBrandThumbnailIsImage($image,$file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status','Brand update successfully');
    }


    public function delete_brand($id)
    {
        $brand = Brand::findOrFail($id);
        if(File::exists(public_path('uploads/brands/').'/'.$brand->image))
        {
         File::delete(public_path('uploads/brands/').'/'.$brand->image);
        }
        if(File::exists(public_path('uploads/brands/thumbnail/').'/'.$brand->image))
        {
             File::delete(public_path('uploads/brands/thumbnail/').'/'.$brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status','Brand deleted successfully');
    }

    //generate image thumbnail
    public function GenerateBrandThumbnailIsImage($image,$imageName)
    {
        $destinationPathThumbnail = public_path('/uploads/brands/thumbnail');
        $destinationPath = public_path('/uploads/brands');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $manager = new ImageManager(new Driver());

        $img = $manager->read($image->getRealPath());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($destinationPath.'/'.$imageName);

        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($destinationPathThumbnail.'/'.$imageName);
    }

    public function category()
    {
        $categories = Category::orderBy('id', 'ASC')->paginate(10);
        return view('admin.category',compact('categories'));
    }

    public function add_category()
    {
        return view('admin.add-category');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->GenerateCategoryThumbnailIsImage($image,$file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.category')->with('status','Category added successfully');
    }

    public function edit_category($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit-category',compact('category'));
    }

    public function update_category(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$request->id,
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if(File::exists(public_path('uploads/categories/').'/'.$category->image))
            {
                 File::delete(public_path('uploads/categories/').'/'.$category->image);
            }
            if(File::exists(public_path('uploads/categories/thumbnail/').'/'.$category->image))
            {
                 File::delete(public_path('uploads/categories/thumbnail/').'/'.$category->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->GenerateCategoryThumbnailIsImage($image,$file_name);
            $category->image = $file_name;
        }
        $category->save();
        return redirect()->route('admin.category')->with('status','Category update successfully');
    }


    public function delete_category($id)
    {
        $category = Category::findOrFail($id);
        if(File::exists(public_path('uploads/categories/').'/'.$category->image))
        {
            File::delete(public_path('uploads/categories/').'/'.$category->image);
        }
        if(File::exists(public_path('uploads/categories/thumbnail/').'/'.$category->image))
        {
             File::delete(public_path('uploads/categories/thumbnail/').'/'.$category->image);
        }
        $category->delete();
        return redirect()->route('admin.category')->with('status','Category deleted successfully');
    }

    //generate image thumbnail
    public function GenerateCategoryThumbnailIsImage($image,$imageName)
    {
        $destinationPathThumbnail = public_path('/uploads/categories/thumbnail');
        $destinationPath = public_path('/uploads/categories');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $manager = new ImageManager(new Driver());

        $img = $manager->read($image->getRealPath());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($destinationPath.'/'.$imageName);

        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($destinationPathThumbnail.'/'.$imageName);
    }

    public function products()
    {
        $products = Product::orderBy('id', 'ASC')->paginate(10);
        return view('admin.products',compact('products'));
    }

    public function add_product()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.add-product',compact('categories','brands'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = $current_timestamp.'.'.$file_extention;
            $this->GenerateProductThumbnailIsImage($image,$file_name);
            $product->image = $file_name;
        }

        $gallery_arr = array();
        $gallery_iamges = "";
        $counter = 1;
        if($request->hasFile('images'))
        {
            $allowedfileExtion = ['jpeg','png','jpg','gif','svg'];
            $files = $request->file('images');
            foreach($files as $file)
            {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension,$allowedfileExtion);
                if($gcheck)
                {
                    $gallery_iamges = $current_timestamp.".".$counter.'.'.$gextension;
                    $this->GenerateProductThumbnailIsImage($file, $gallery_iamges, 'product-gallery');
                    array_push($gallery_arr,$gallery_iamges);
                    $counter = $counter + 1;
                }
            }
            $gallery_iamges = implode(',',$gallery_arr);
            $product->images = $gallery_iamges;
         }
         $product->save();
         return redirect()->route('admin.products')->with('status','Product added successfully');
    }

    public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.edit-product',compact('product','categories','brands'));
    }

    public function update_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,'.$request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        $product = Product::findOrFail($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image'))
        {
            if(File::exists(public_path('uploads/products/').'/'.$product->image))
            {
                 File::delete(public_path('uploads/products/').'/'.$product->image);
            }
            if(File::exists(public_path('uploads/products/thumbnail/').'/'.$product->image))
            {
                 File::delete(public_path('uploads/products/thumbnail/').'/'.$product->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = $current_timestamp.'.'.$file_extention;
            $this->GenerateProductThumbnailIsImage($image,$file_name);
            $product->image = $file_name;
        }

        $gallery_arr = array();
        $gallery_iamges = "";
        $counter = 1;

        if($request->hasFile('images'))
        {
            foreach(explode(',',$product->images) as $img)
            {
                if(File::exists(public_path('uploads/product-gallery/').'/'.$img))
                {
                     File::delete(public_path('uploads/product-gallery/').'/'.$img);
                }
                if(File::exists(public_path('uploads/product-gallery/thumbnail/').'/'.$img))
                {
                     File::delete(public_path('uploads/product-gallery/thumbnail/').'/'.$img);
                }
            }

            $allowedfileExtion = ['jpeg','png','jpg','gif','svg'];
            $files = $request->file('images');
            foreach($files as $file)
            {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension,$allowedfileExtion);
                if($gcheck)
                {
                    $gallery_iamges = $current_timestamp.".".$counter.'.'.$gextension;
                    $this->GenerateProductThumbnailIsImage($file, $gallery_iamges, 'product-gallery');
                    array_push($gallery_arr,$gallery_iamges);
                    $counter = $counter + 1;
                }
            }
            $gallery_iamges = implode(',',$gallery_arr);
            $product->images = $gallery_iamges;
         }
         $product->save();
         return redirect()->route('admin.products')->with('status','Product update successfully');
    }

    public function delete_product($id)
    {
        $product = Product::findOrFail($id);

        if(File::exists(public_path('uploads/products/').'/'.$product->image))
        {
             File::delete(public_path('uploads/products/').'/'.$product->image);
        }
        if(File::exists(public_path('uploads/products/thumbnail/').'/'.$product->image))
        {
             File::delete(public_path('uploads/products/thumbnail/').'/'.$product->image);
        }

        foreach(explode(',',$product->images) as $img)
        {
            if(File::exists(public_path('uploads/product-gallery/').'/'.$img))
            {
                 File::delete(public_path('uploads/product-gallery/').'/'.$img);
            }
            if(File::exists(public_path('uploads/product-gallery/thumbnail/').'/'.$img))
            {
                 File::delete(public_path('uploads/product-gallery/thumbnail/').'/'.$img);
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status','Product has been deleted successfully');
    }

    public function GenerateProductThumbnailIsImage($image, $imageName, $folder = 'products')
    {
        $destinationPathThumbnail = public_path('/uploads/' . $folder . '/thumbnail');
        $destinationPath = public_path('/uploads/' . $folder);

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        if (!file_exists($destinationPathThumbnail)) {
            mkdir($destinationPathThumbnail, 0777, true);
        }

        $manager = new ImageManager(new Driver());

        $img = $manager->read($image->getRealPath());
        $img->cover(540, 689, "top");
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($destinationPath . '/' . $imageName);

        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($destinationPathThumbnail . '/' . $imageName);
    }

}
