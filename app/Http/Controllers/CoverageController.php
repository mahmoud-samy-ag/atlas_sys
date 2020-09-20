<?php

namespace App\Http\Controllers;

use App\Coverage;
use App\Doctor;
use App\ParentUserChildUser;
use Illuminate\Http\Request;

class CoverageController extends Controller
{
 
    public function index(Request $request)
    {


        $from='2019-12-01';
        $to= date("Y-m-d" , strtotime('now -24'));

        
        if($request->has('from') || $request->has('to') ){
            if(empty($request->from) || empty($request->to) ){
                
            }
            else{
                if(strtotime($request->from)<strtotime($request->to)){
                    $from=$request->from;
                    $to=date("Y-m-d" , strtotime($request->to.'-24'));
                    
                }
            }
        }
        

        if(auth()->user()->hasRole('ceo')){
            $doctors = Doctor::latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('product_specialist')){

            $doctors = Doctor::where('created_by' , auth()->user()->id)
            ->latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('district_manager')){

            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }

            $doctors = Doctor::whereIn('created_by' , $childs_id)
            ->latest()
            ->paginate(200);
        }

        elseif(auth()->user()->hasRole('regional_manager')){


            $district_manager_data=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $district_manager_id=[];
            foreach($district_manager_data as $index=>$child_id){
                $district_manager_id[$index]=$child_id->child_id;
            }
            // return $district_manager_id;

            $childData=ParentUserChildUser::whereIn('parent_id' , $district_manager_id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }

            $doctors = Doctor::whereIn('created_by' , $childs_id)
            ->latest()
            ->paginate(200);
        }



        

        // return $coverages[0];

        return view('layouts.coverages.index' , compact('doctors' , 'from' , 'to' ));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

  
    public function show(Coverage $coverage)
    {
        //
    }

    public function edit(Coverage $coverage)
    {
        //
    }

    public function update(Request $request, Coverage $coverage)
    {
        //
    }

    public function destroy(Coverage $coverage)
    {
        //
    }
}
