<?php

namespace App\Http\Controllers;

use App\SalesReport;
use App\User;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{

    public function index()
    {
        $product_specialists= User::whereHas('roles', function($q){
            $q->where('name', 'product_specialist');
        })->get();
        return view('layouts.salesReports.index' , compact('product_specialists'));
    }


    public function create($user_id)
    {
        $product_specialist= User::where(['id' => $user_id])->get()[0];
        return view('layouts.salesReports.create' , compact('product_specialist'));
    }

    public function store(Request $request)
    {
        $request->validate([    // validation values
            'user_id' => 'required',
            'ucp' => 'required',
            'direct_sales' => 'required'
        ]);

        
        SalesReport::create($request->except(['_token']));
        session()->flash('success','the sales report has been added successfuly'); 
        return redirect()->route('sales_report.index');
    }

    public function show(Request $request , $user_id)
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
        
        
        $reports = SalesReport::whereBetween('created_at', array($from, $to))
            ->where(['user_id' => $user_id])
            ->latest()
            ->paginate(200);
        return view('layouts.salesReports.user_reports' , compact('reports' , 'user_id'));;
    }

    public function edit(SalesReport $salesReport)
    {
        
        return view('layouts.salesReports.edit' , compact('salesReport'));
    }

    public function update(Request $request, SalesReport $salesReport)
    {
        $request->validate([    // validation values
            'ucp' => 'required',
            'direct_sales' => 'required'
        ]);

        
        $salesReport->update($request->except(['_token']));
        session()->flash('success','the sales report has been updated successfuly'); 
        return redirect()->route('sales_report.show' , $salesReport->user_id);
    }

    public function destroy(SalesReport $salesReport)
    {
        //
    }
}
