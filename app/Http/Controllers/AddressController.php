<?php

namespace App\Http\Controllers;

use App\Address;
use App\ParentUserChildUser;
use Illuminate\Http\Request;

class AddressController extends Controller
{

  
    public function index(Request $request)
    {       

        if(auth()->user()->hasRole('ceo')){

            $addresses = Address::latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('product_specialist')){

            $addresses = Address::where('creator_id' , auth()->user()->id)
            ->latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('district_manager')){
            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
            $addresses = Address::whereIn('creator_id' ,$childs_id)
            ->latest()
            ->paginate(200);
        }
        
        return view('layouts.addresses.index' , compact('addresses'));
    }










    public function create()
    {
     
        return view('layouts.addresses.create');
    }
    public function store(Request $request)
    {
        $request->validate([    // validation values
            'name' => ['required','unique:addresses']
        ]);

        $adress_name['name']=$request->name;
        $adress_name['creator_id']=auth()->user()->id;

        $address= Address::create($adress_name);
        session()->flash('success','the address has been added successfuly'); 
        return redirect()->route('addresses.index');
    }
    public function show(Address $address)
    {
        //
    }
    public function edit(Address $address)
    {
        return view('layouts.addresses.edit' , compact('address'));
    }
    public function update(Request $request, Address $address)
    {
        if($address->name == $request->name){
            $request->validate([    // validation values
                'name' => ['required']
            ]);
        }
        else{
            $request->validate([    // validation values
                'name' => ['required','unique:addresses']
            ]);
        }
        
        $address->update($request->except(['_token']));
        session()->flash('success','the address has been updated successfuly'); 
        return redirect()->route('addresses.index');
    }
    public function destroy(Address $address)
    {
        Address::destroy($address->id);
        session()->flash('success','the address has been removed successfuly'); 
        return redirect()->route('addresses.index');
    }
}