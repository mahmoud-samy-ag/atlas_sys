<?php

namespace App\Http\Controllers;

use App\WeeklyPlan;
use App\WeeklyPlanDay;
use App\WeeklyPlanDayDoctor;
use App\Doctor;
use App\User;
use App\Product;
use App\ParentUserChildUser;
use Auth;
use DB;
use Illuminate\Http\Request;

class WeeklyPlanController extends Controller
{


    public function __construct(){
        // $this->middleware(['role:district_manager'])->only('index');
    }


    
 
    public function index(Request $request)
    {

        
        $days=[
            'Saturday' => date("Y-m-d",strtotime('Saturday this week')),
            'Thursday' => date("Y-m-d",strtotime('Thursday this week')),
            'Friday' => date("Y-m-d",strtotime('Friday this week')),
        ];

        $now = date("Y-m-d",strtotime('now'));

       
        
        $user=User::where('id' , Auth::id())->get()[0];
        $current_plan = WeeklyPlan::where(['start_at' => $days['Saturday'], 'user_id' => $user->id])->get() ;
        
        if($now==$days['Thursday'] || $now==$days['Friday']){
            $plan_access=true;
            if(empty($current_plan[0])){
                $plan_checker=true;
            }
            else{
                $plan_checker=false;
            }
        }
        else{
            $plan_access=false;
            $plan_checker=false;
        }
        

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
        
        
        if($user->hasRole('ceo')){
            $weeklyPlans = WeeklyPlan::whereBetween('created_at', array($from, $to))
            ->latest()
            ->paginate(200);
        }
        elseif($user->hasRole('product_specialist')){
            $weeklyPlans = WeeklyPlan::with('day')->whereBetween('created_at', array($from, $to))
            ->where('user_id' , $user->id)->with('creator')
            ->latest()
            ->paginate(200);
        }
        elseif($user->hasRole('district_manager')){

            $childData=ParentUserChildUser::where('parent_id' , $user->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
             $weeklyPlans = WeeklyPlan::whereBetween('created_at', array($from, $to))
            ->whereIn('user_id' ,$childs_id)->with('creator')
            ->orWhere('user_id' , auth()->user()->id)
            ->latest()
            ->paginate(200);
        }
        
        return view('layouts.weeklyPlans.index' , compact('weeklyPlans' , 'plan_checker' , 'plan_access'));
    }

    public function create()
    {

        
        $product_specialists='';
        $product_specilaist_day='';
        date_default_timezone_set('Africa/Cairo');
        
        $weekDays=[
            'Saturday' => date("Y-m-d",strtotime('Saturday this week')),
            'Sunday' => date("Y-m-d",strtotime('Sunday this week')),
            'Monday' => date("Y-m-d",strtotime('Monday next week')),
            'Tuesday' => date("Y-m-d",strtotime('Tuesday next week')),
            'Wednesday' => date("Y-m-d",strtotime('Wednesday next week')),
            'Thursday' => date("Y-m-d",strtotime('Thursday next week')),
            'Friday' => date("Y-m-d",strtotime('Friday next week')),
        ];
        

        // return $weekDays['Saturday'];
       

        $weeklyPlan= WeeklyPlan::all();


        if(auth()->user()->hasRole('product_specialist')){
            $doctors= Doctor::with('addresses')->where(['category' => 'doctor' , 'created_by' => auth()->user()->id , 'approve' => 'approved'])->get();
            $hospitals= Doctor::with('addresses')->where(['category' => 'hospital' , 'created_by' => auth()->user()->id ,'approve' => 'approved'])->get();
            $pharmacies= Doctor::with('addresses')->where(['category' => 'pharmacy' , 'created_by' => auth()->user()->id , 'approve' => 'approved'])->get();
            
        }
        elseif(auth()->user()->hasRole('district_manager')){
            
          

            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }

            $product_specialists = DB::table('users')
            ->join('weekly_plans', 'users.id', '=', 'weekly_plans.user_id')
            ->where(['weekly_plans.start_at' => $weekDays['Saturday']])
            ->whereIn('users.id' , $childs_id)
            ->get(['users.id as user_id' , 'weekly_plans.id as weekly_plan_id' , 'users.name']);


            $product_specilaist_day = DB::table('users')
            ->join('weekly_plans', 'users.id', '=', 'weekly_plans.user_id')
            ->join('weekly_plan_days', 'weekly_plans.id', '=', 'weekly_plan_days.plan_id')
            ->join('weekly_plan_day_doctors', 'weekly_plan_days.id', '=', 'weekly_plan_day_doctors.day_id')
            ->join('doctors', 'weekly_plan_day_doctors.doctor_id', '=', 'doctors.id')
            ->where(['weekly_plans.start_at' => $weekDays['Saturday']])
            ->whereIn('users.id' , $childs_id)
            ->get([
                'users.id as user_id' , 
                'weekly_plans.id as weekly_plan_id' , 
                'users.name' , 
                'weekly_plan_days.start_point' , 
                'weekly_plan_days.start_time',
                'weekly_plan_days.day_date',
                'weekly_plan_day_doctors.day_id',
                'doctors.id as doctor_id',
                'doctors.name as doctor_name',
                'doctors.category as doctor_category',
                'doctors.hospital_pharmacy_client as hospital_pharmacy_client',
                'doctors.period',
                ]);



            


            
            array_push($childs_id,auth()->user()->id);


            $doctors= Doctor::with('addresses')->where('category' , 'doctor')->whereIn('created_by' , $childs_id)->get();
            $hospitals= Doctor::with('addresses')->where('category' , 'hospital')->whereIn('created_by' , $childs_id)->get();
            $pharmacies= Doctor::with('addresses')->where('category' , 'pharmacy')->whereIn('created_by' , $childs_id)->get();

        }


        
        $products= Product::all();
        
        // return $doctors;
        return view('layouts.weeklyPlans.create' , compact( 'product_specilaist_day' ,'product_specialists' , 'hospitals' , 'pharmacies' , 'weeklyPlans' , 'weekDays' , 'doctors' , 'products'));
    }

    public function store(Request $request)
    {

        

        date_default_timezone_set('Africa/Cairo');
        
        $weekDays=[
            'Saturday' => date("Y-m-d",strtotime('Saturday this week')),
            'Friday' => date("Y-m-d",strtotime('friday next week')),
        ];
        $start_at = $weekDays['Saturday'];
        $end_at = $weekDays['Friday'];
        


        
        if( strtotime("now")>  $weekDays['Friday'] ){
            // send late mail to managers
        }

        $weeklyPlanData=[
            'user_id' =>Auth::id(),
            'start_at' => $start_at,
            'end_at' =>$end_at,
        ];

        
        $weeklyPlan= WeeklyPlan::create($weeklyPlanData);

       

        for($i=0 ; $i <= 6 ; $i++){

            if($i==0){$day='Saturday';}
            if($i==1){$day='Sunday';}
            if($i==2){$day='Monday';}
            if($i==3){$day='Tuesday';}
            if($i==4){$day='Wednesday';}
            if($i==5){$day='Thursday';}
            if($i==6){$day='Friday';}

            $weeklyPlanDayData = [];
            $weeklyPlanDayData['day_date'] = $request->day_date[$i] ;
            $weeklyPlanDayData['start_time'] = $request->start_time[$i] ;
            $weeklyPlanDayData['start_point'] = $request->start_point[$i] ;
            if($request->has('product_specialist')){
                $weeklyPlanDayData['product_specialist'] = $request->product_specialist[$i];
            }
            $weeklyPlanDayData['plan_id']=$weeklyPlan->id;
            $weeklyPlanDay= WeeklyPlanDay::create($weeklyPlanDayData);

            

            $doctor_id=$day.'_doctor_id';
            if(!empty($request->$doctor_id)){
                foreach($request->$doctor_id as $id){
                    $weeklyPlanDayDoctorData = [];
                    $weeklyPlanDayDoctorData['plan_id'] = $weeklyPlan->id ;
                    $weeklyPlanDayDoctorData['day_id'] = $weeklyPlanDay->id ;
                    $weeklyPlanDayDoctorData['doctor_id'] = $id ;
                    $weeklyPlanDayDoctor= WeeklyPlanDayDoctor::create($weeklyPlanDayDoctorData);
                }
            }
        }
        session()->flash('success','the weekly Plan has been added successfuly'); 
        return redirect()->route('weeklyPlans.index');
    }

    public function show(WeeklyPlan $weeklyPlan)
    {

        $weekData=WeeklyPlan::where('id' , $weeklyPlan->id)->with('doctor' , 'day')->get()[0];
        $creator=User::with('parent')->where('id' , $weeklyPlan->user_id)->get()[0];
        $district_manager=User::with('areas')->where('id' , $creator->parent->parent_id)->get()[0];

        // return $weekData;
        return view('layouts.weeklyPlans.show' , compact('weekData' , 'creator' , 'district_manager'));
    }


    public function edit($dayID)
    {

        if(auth()->user()->hasRole('product_specialist')){
            $doctors= Doctor::with('addresses')->where(['category' => 'doctor' , 'created_by' => auth()->user()->id])->get();
            $hospitals= Doctor::with('addresses')->where(['category' => 'hospital' , 'created_by' => auth()->user()->id])->get();
            $pharmacies= Doctor::with('addresses')->where(['category' => 'pharmacy' , 'created_by' => auth()->user()->id])->get();
            
        }
        elseif(auth()->user()->hasRole('district_manager')){
            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
            $doctors= Doctor::with('addresses')->where('category' , 'doctor')->whereIn('created_by' , $childs_id)->get();
            $hospitals= Doctor::with('addresses')->where('category' , 'hospital')->whereIn('created_by' , $childs_id)->get();
            $pharmacies= Doctor::with('addresses')->where('category' , 'pharmacy')->whereIn('created_by' , $childs_id)->get();

        }

        $day=WeeklyPlanDay::where('id' , $dayID)->get()[0];
        return view('layouts.weeklyPlans.edit' , compact('day' , 'doctors' , 'hospitals' , 'pharmacies'));
    }


    public function update(Request $request, $weeklyPlanDayId)
    {
        
        $dayData=[];
        $dayData['start_time'] = $request->start_time;
        $dayData['start_point'] = $request->start_point;
        if($request->has('product_specialist')){
            $dayData['product_specialist'] = $request->product_specialist;
        }


        WeeklyPlanDay::where('id' , $weeklyPlanDayId)->update($dayData);
        $day=WeeklyPlanDay::where('id' , $weeklyPlanDayId)->get()[0];
        WeeklyPlanDayDoctor::where('day_id' , $weeklyPlanDayId)->delete();


        if(!empty($request->doctor_id)){
            foreach($request->doctor_id as $id){
                $weeklyPlanDayDoctorData = [];
                $weeklyPlanDayDoctorData['plan_id'] = $day->plan_id ;
                $weeklyPlanDayDoctorData['day_id'] = $day->id ;
                $weeklyPlanDayDoctorData['doctor_id'] = $id ;
                $weeklyPlanDayDoctor= WeeklyPlanDayDoctor::create($weeklyPlanDayDoctorData);
            }
        }
        
        session()->flash('success','the  has been updated successfuly'); 
        return redirect()->route('weeklyPlans.index');
    }

    public function destroy(WeeklyPlan $weeklyPlan)
    {
        WeeklyPlanDayDoctor::where('plan_id' , $weeklyPlan->id)->delete();
        WeeklyPlanDay::where('plan_id' , $weeklyPlan->id)->delete();
        WeeklyPlan::destroy($weeklyPlan->id);

        


        session()->flash('success','the weekly Plan has been removed successfuly'); 
        return redirect()->route('weeklyPlans.index');
    }
}
