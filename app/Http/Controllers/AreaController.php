<?php

namespace App\Http\Controllers;

use App\Area;
use App\ParentUserChildUser;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    public function index(Request $request)
    {
        $areas = Area::latest()->paginate(200);
        return view('layouts.areas.index' , compact('areas'));
    }


    public function create()
    {

        $areas= Area::all();
        return view('layouts.areas.create' , compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([    // validation values
            'name' => ['required','unique:areas'],
            'for' => 'required',
        ]);

        
        $area= area::create($request->except(['_token']));
        session()->flash('success','the area has been added successfuly'); 
        return redirect()->route('areas.index');
    }


    public function show(Area $area)
    {
        //
    }

    public function edit(Area $area)
    {
        return view('layouts.areas.edit' , compact('area'));
    }


    public function update(Request $request, Area $area)
    {

        if($area->name == $request->name){
            $request->validate([    // validation values
                'name' => ['required']
            ]);
        }
        else{
            $request->validate([    // validation values
                'name' => ['required','unique:areas']
            ]);
        }
        

        $area->update($request->except(['_token']));
        session()->flash('success','the area has been updated successfuly'); 
        return redirect()->route('areas.index');
    }


    public function destroy(Area $area)
    {
        Area::destroy($area->id);
        session()->flash('success','the area has been removed successfuly'); 
        return redirect()->route('areas.index');
    }
}
