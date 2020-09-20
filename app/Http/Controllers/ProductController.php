<?php

namespace App\Http\Controllers;

use App\Product;
use App\Doctor;
use App\DailyReportDoctor;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::when($request->search , function($query) use ($request) {    
            return $query->where('name' , 'like' , '%'.$request->search.'%');
        })->latest()->paginate(200);

        
        $reportDoctors=DailyReportDoctor::all();

        $reportDoctorData=[];
        foreach($reportDoctors as $index=>$id){
            $reportDoctorData[$index]=$id->doctor_id;
        }

        $doctors=Doctor::whereIn('id' , $reportDoctorData)->get();
        return view('layouts.products.index' , compact('products' , 'doctors'));


    }

 
    public function create()
    {
        $products= Product::all();
        return view('layouts.products.create' , compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([    // validation values
            'name' => ['required','unique:products']
        ]);

        
        $product= Product::create($request->except(['_token']));
        session()->flash('success','the product has been added successfuly'); 
        return redirect()->route('products.index');
    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        return view('layouts.products.edit' , compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        if($product->name == $request->name){
            $request->validate([    // validation values
                'name' => ['required']
            ]);
        }
        else{
            $request->validate([    // validation values
                'name' => ['required','unique:products']
            ]);
        }
        

        $product->update($request->except(['_token']));
        session()->flash('success','the product has been updated successfuly'); 
        return redirect()->route('products.index');
    }


    public function destroy(Product $product)
    {
        Product::destroy($product->id);
        session()->flash('success','the product has been removed successfuly'); 
        return redirect()->route('products.index');
    }
}
