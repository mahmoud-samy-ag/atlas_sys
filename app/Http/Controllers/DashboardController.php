<?php

namespace App\Http\Controllers;
use App\Product;
use App\Doctor;
use DB;
use App\User;
use App\SalesReport;
use App\DailyReportDoctor;
use App\DailyReportDoctorProduct;
use App\ParentUserChildUser;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::all();

        $reportDoctors=DailyReportDoctor::all();
        $reportDoctorData=[];
        foreach($reportDoctors as $index=>$id){
            $reportDoctorData[$index]=$id->doctor_id;
        }

        $start_week = date("Y-m-d",strtotime('Saturday previous week'));
        $end_week = date("Y-m-d",strtotime('Saturday this week'));

        $week_reportDoctors=DailyReportDoctor::whereBetween('created_at', array($start_week, $end_week))->get();
        $week_reportDoctorData=[];
        foreach($week_reportDoctors as $index=>$id){
            $week_reportDoctorData[$index]=$id->doctor_id;
        }


        
        

        $start_month = date('Y-m-01');
        $end_month = date('Y-m-t');
        $month_reportDoctors=DailyReportDoctor::whereBetween('created_at', array($start_month, $end_month))->get();
        $month_reportDoctorData=[];
        foreach($month_reportDoctors as $index=>$id){
            $month_reportDoctorData[$index]=$id->doctor_id;
        }


        

        $all_customers=Doctor::where(['created_by' => auth()->user()->id , 'category' => 'doctor'])->get()->count();
        $week_visited_customers=Doctor::whereIn('id' , $week_reportDoctorData)->where(['created_by' => auth()->user()->id , 'category' => 'doctor'])->get()->count();
        $month_visited_customers=Doctor::whereIn('id' , $month_reportDoctorData)->where(['created_by' => auth()->user()->id , 'category' => 'doctor'])->get()->count();

        $doctors=Doctor::whereIn('id' , $reportDoctorData)->get();



        $from=$start_month;
        $to= $end_month;

        
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
        
        $product_specialists='';
        
        if(auth()->user()->hasRole('ceo') || auth()->user()->hasRole('general_manager')){
            $salesReports = SalesReport::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(ucp) as ucp'),
                DB::raw('SUM(direct_sales) as direct_sales')
            )->groupBy('date')
            ->whereBetween('created_at', array($from, $to))
            ->get();

            $product_specialists=User::whereHas('roles', function($q){$q->whereIn('name', ['product_specialist']);})->get();
        }
        elseif(auth()->user()->hasRole('product_specialist')){
            $salesReports = SalesReport::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(ucp) as ucp'),
                DB::raw('SUM(direct_sales) as direct_sales')
            )->groupBy('date')
            ->whereBetween('created_at', array($from, $to))
            ->where('user_id' , auth()->user()->id)
            ->get();

        }
        elseif(auth()->user()->hasRole('district_manager')){

            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
            

            $salesReports = SalesReport::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(ucp) as ucp'),
                DB::raw('SUM(direct_sales) as direct_sales')
            )->groupBy('date')
            ->whereBetween('created_at', array($from, $to))
            ->whereIn('user_id' , $childs_id)
            ->get();

            $product_specialists=User::whereIn('id' , $childs_id)->get();
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

            $salesReports = SalesReport::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(ucp) as ucp'),
                DB::raw('SUM(direct_sales) as direct_sales')
            )->groupBy('date')
            ->whereBetween('created_at', array($from, $to))
            ->whereIn('user_id' , $childs_id)
            ->get();

            $product_specialists=User::whereIn('id' , $childs_id)->get();
        }


        

        if(auth()->user()->hasRole('sales_manager')){
            return redirect('sales_report');
        }
        else{
            return view('layouts.home' , compact('product_specialists' , 'salesReports','products' , 'doctors' , 'all_customers' , 'week_visited_customers' , 'month_visited_customers' ));
        }
    }



    

    public function product_feedback($id)
    {
        $feedbacks = DailyReportDoctorProduct::where('product_id' , $id)->get();


        $doctor_ids=[];
        foreach($feedbacks as $index=>$feedback){
            $doctor_ids[$index]=$feedback->doctor_id;
        }

        if(auth()->user()->hasRole('ceo') || auth()->user()->hasRole('general_manager')){
            $doctors = Doctor::whereIn('id' , $doctor_ids)->with('product_feedback')->get();
        }
        elseif(auth()->user()->hasRole('product_specialist')){
            $doctors = Doctor::whereIn('id' , $doctor_ids)->where(['created_by' => auth()->user()->id])->with('product_feedback')->get();
        }
        elseif(auth()->user()->hasRole('district_manager')){

            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
            
            $doctors = Doctor::whereIn('id' , $doctor_ids)->whereIn('created_by' , $childs_id)->with('product_feedback')->get();
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

            $doctors = Doctor::whereIn('id' , $doctor_ids)->whereIn('created_by' , $childs_id)->with('product_feedback')->get();
        }
        return view('layouts.product_feedback' , compact('feedbacks' , 'doctors'));
    }



    public function sales_graph(Request $request , $user_id)
    {

        $from = date('Y-m-01');
        $to =  date('Y-m-d', strtotime(date('Y-m-t'). ' + 1 days'));
       


        
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


        $salesReports = SalesReport::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(ucp) as ucp'),
            DB::raw('SUM(direct_sales) as direct_sales')
        )->groupBy('date')
        ->whereBetween('created_at', array($from, $to))
        ->where('user_id' , $user_id)
        ->get();

        return view('layouts.sales_graph' , compact('salesReports' , 'user_id'));
    }

}
