<?php

namespace App\Http\Controllers;

use App\Doctor;
use DB;
use Auth;
use App\Address;
use App\Coverage;
use App\AddressDoctor;
use App\ParentUserChildUser;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function index()
    {

        if(auth()->user()->hasRole('ceo') || auth()->user()->hasRole('general_manager')){

            $doctors = Doctor::latest()
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

            $doctors = Doctor::whereIn('created_by' ,$childs_id)
            ->latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('district_manager')){
            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
            array_push($childs_id,auth()->user()->id);

            $doctors = Doctor::whereIn('created_by' ,$childs_id)
            ->latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('product_specialist')){
            $doctors = Doctor::where(['created_by' => auth()->user()->id , 'approve' => 'approved'])
            ->latest()
            ->paginate(200);
        }

        

        return view('layouts.doctors.index' , compact('doctors'));
    }

 
    public function create()
    {
        $addresses = Address::all();
        return view('layouts.doctors.create' , compact('addresses'));
    }

    public function store(Request $request)
    {
        

        if($request->category=='doctor'){

            $request->validate([    
                'doctor_name' => ['required'],
                'spec' => ['required'],
                'address' => ['required'],
                'class' => ['required']
            ]);
            $data_request=[
                'category' => $request->category,
                'name' => $request->doctor_name,
                'spec' => $request->spec,
                'class' => $request->class,
                'visiting_time' => $request->visiting_time,
                'period' => 'pm',
                'kol' => $request->kol,
                'created_by' => Auth::id(),
            ];

            
        }
        elseif($request->category=='hospital'){
            $request->validate([    
                'hospital_name' => ['required'],
                'hospital_doctor' => ['required'],
                'hospital_category' => ['required'],
            ]);
            $data_request=[
                'category' => $request->category,
                'name' => $request->hospital_name,
                'hospital_pharmacy_client' => $request->hospital_doctor,
                'hospital_category' => $request->hospital_category,
                'visiting_time' => $request->visiting_time,
                'period' => 'am',
                'created_by' => Auth::id(),
            ];
        }
        elseif($request->category=='pharmacy'){
            $request->validate([    
                'pharmacy_name' => ['required'],
                'pharmacist' => ['required'],
                'period' => ['required'],
            ]);
            $data_request=[
                'category' => $request->category,
                'name' => $request->pharmacy_name,
                'hospital_pharmacy_client' => $request->pharmacist,
                'visiting_time' => $request->visiting_time,
                'period' => $request->period,
                'created_by' => Auth::id(),
            ];
        }

        if(auth()->user()->hasRole('district_manager')){
            $data_request['approve']='approved';
        }


        $doctor= doctor::create($data_request);
        AddressDoctor::create(['address_id' => $request->address , 'doctor_id' => $doctor->id ]);

        Coverage::create(['doctor_id' => $doctor->id , 'creator_id' => auth()->user()->id]);

        
        
        session()->flash('success','the customer has been added successfuly'); 
        return redirect()->route('doctors.index');
    }

 
    public function show(Doctor $doctor)
    {
        //
    }

    public function edit(Doctor $doctor)
    {
        return view('layouts.doctors.edit' , compact('doctor'));
    }


    public function update(Request $request, Doctor $doctor)
    {

        if($doctor->name == $request->name){
            $request->validate([    // validation values
                'name' => ['required']
            ]);
        }
        else{
            $request->validate([    // validation values
                'name' => ['required','unique:doctors']
            ]);
        }
        

        $doctor->update($request->except(['_token']));
        session()->flash('success','the doctor has been updated successfuly'); 
        return redirect()->route('doctors.index');
    }

    public function destroy(Doctor $doctor)
    {
        Doctor::destroy($doctor->id);
        session()->flash('success','the doctor has been removed successfuly'); 
        return redirect()->route('doctors.index');
    }

    public function approve($doctor_id)
    {
        DB::table('doctors')->where('id', $doctor_id) ->update(['approve' => 'approved']);
        return redirect()->route('doctors.index');
    }
}
