<?php

namespace App\Http\Controllers;

use App\DailyReport;
use App\DailyReportDoctor;
use App\DailyReportDoctorProduct;
use Auth;
use App\Doctor;
use App\Coverage;
use App\CoverageVisiting;
use App\CoverageVisitingProduct;
use App\ParentUserChildUser;
use App\Product;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
  
    public function index(Request $request)
    {



        $current_report = DailyReport::whereBetween('created_at', array( date("Y-m-d" , strtotime('now')) , date("Y-m-d" , strtotime('now -24')) ))
        ->where( 'creator_id' , auth()->user()->id )
        ->get() ;
        
        if(empty($current_report[0])){
            $report_checker=true;
        }
        else{
            $report_checker=false;
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
        
        
        if(auth()->user()->hasRole('ceo')){
            $dailyReports = DailyReport::whereBetween('created_at', array($from, $to))
            ->latest()
            ->with('doctor_ids')
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('product_specialist')){
            $dailyReports = DailyReport::whereBetween('created_at', array($from, $to))
            ->where('creator_id' , auth()->user()->id)->with('doctor_ids')
            ->latest()
            ->paginate(200);

            // return $dailyReports;
        }
        elseif(auth()->user()->hasRole('district_manager')){
            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
             $dailyReports = DailyReport::whereBetween('created_at', array($from, $to))
            ->whereIn('creator_id' ,$childs_id)->with('doctor_ids')
            ->latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('regional_manager')){
            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
             $dailyReports = DailyReport::whereBetween('created_at', array($from, $to))
            ->whereIn('creator_id' ,$childs_id)->with('doctor_ids')
            ->latest()
            ->paginate(200);
        }

        

        return view('layouts.dailyReports.index' , compact('report_checker' , 'dailyReports'));
    }

 
    public function create()
    {
        $dailyReports= DailyReport::all();
        $doctors= Doctor::with('addresses')->where('category' , 'doctor')->get();
        $hospitals= Doctor::with('addresses')->where('category' , 'hospital')->get();
        $pharmacies= Doctor::with('addresses')->where('category' , 'pharmacy')->get();
        $products= Product::all();
        return view('layouts.dailyReports.create' , compact( 'hospitals' , 'pharmacies' , 'dailyReports' , 'doctors' , 'products'));
    }

    public function store(Request $request)
    {

        $dailyReport= DailyReport::create(['creator_id' =>Auth::id()]);

        if($request->has('doctor_id')){
            foreach($request->doctor_id as $index=>$id){

                
                
                $dailyReportDoctorData = [];
                $dailyReportDoctorData['report_id'] = $dailyReport->id ;
                $dailyReportDoctorData['doctor_id'] = $id ;
                $dailyReportDoctorData['comm_and_feed'] = $request->doctor_comm_and_feed[$index] ;

                
                $dailyReportDoctor= DailyReportDoctor::create($dailyReportDoctorData);

                $kol= Doctor::where('id' , $id)->get()[0]->kol;

                if($kol=='kol'){
                    $coverage_visiting = CoverageVisiting::create(['doctor_id' => $id , 'report_id' => $dailyReport->id]);
                    $product_name='doctor_id_'.$id.'_product';
                    if($request->has($product_name)){
                        foreach($request->$product_name as $index=>$product){
                            $coverage_product = [];
                            $coverage_product['report_id'] = $dailyReport->id ;
                            $coverage_product['visiting_id'] = $coverage_visiting->id ;
                            $coverage_product['product_id'] = $product ;
                            CoverageVisitingProduct::create($coverage_product);
                        }
                    }
                }

                
                $product_name='doctor_id_'.$id.'_product';
                if($request->has($product_name)){
                    foreach($request->$product_name as $index=>$product){
                        $dailyReportDoctorProductData = [];
                        $dailyReportDoctorProductData['report_id'] = $dailyReport->id ;
                        $dailyReportDoctorProductData['doctor_id'] = $dailyReportDoctor->id ;
                        $dailyReportDoctorProductData['product_id'] = $product ;
                        DailyReportDoctorProduct::create($dailyReportDoctorProductData);
                    }
                }
            
            }
        }
        

        session()->flash('success','the daily report has been added successfuly'); 
        return redirect()->route('dailyReports.index');
    }

    public $timestamps = false;

    public function show(DailyReport $dailyReport , Request $request)
    {

        
        $doctors = DailyReportDoctor::where('report_id' , $dailyReport->id)
        ->latest()
        ->paginate(200);

        

        // return $doctors[0];
        return view('layouts.dailyReports.show' , compact('doctors' , 'dailyReport'));
    }

 
    public function edit(DailyReport $dailyReport)
    {
        return view('layouts.dailyReports.edit' , compact('dailyReports'));
    }

 
    public function update(Request $request, DailyReport $dailyReport)
    {
        if($dailyReport->name == $request->name){
            $request->validate([    // validation values
                'name' => ['required']
            ]);
        }
        else{
            $request->validate([    // validation values
                'name' => ['required','unique:dailyReports']
            ]);
        }
        

        $dailyReport->update($request->except(['_token']));
        session()->flash('success','the daily report has been updated successfuly'); 
        return redirect()->route('dailyReports.index');
    }

    public function destroy(DailyReport $dailyReport)
    {

        

        CoverageVisitingProduct::where('report_id' , $dailyReport->id)->delete();
        CoverageVisiting::where('report_id' , $dailyReport->id)->delete();
        DailyReportDoctorProduct::where('report_id' , $dailyReport->id)->delete();
        DailyReportDoctor::where('report_id' , $dailyReport->id)->delete();
        DailyReport::destroy($dailyReport->id);


        session()->flash('success','the daily report has been removed successfuly'); 
        return redirect()->route('dailyReports.index');

    }
}
