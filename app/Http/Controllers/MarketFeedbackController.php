<?php

namespace App\Http\Controllers;

use App\MarketFeedback;
use App\MarketFeedbackProduct;
use App\ParentUserChildUser;
use App\Doctor;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class MarketFeedbackController extends Controller
{

    public function index(Request $request)
    {
        //$output=explode("/",$sting);
       

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
            $marketFeedbacks = MarketFeedback::whereBetween('created_at', array($from, $to))
            ->latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('product_specialist')){
            $marketFeedbacks = MarketFeedback::whereBetween('created_at', array($from, $to))
            ->where('creator_id' , auth()->user()->id)
            ->latest()
            ->paginate(200);
        }
        elseif(auth()->user()->hasRole('district_manager')){

            $childData=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $childs_id=[];
            foreach($childData as $index=>$child_id){
                $childs_id[$index]=$child_id->child_id;
            }
             $marketFeedbacks = MarketFeedback::whereBetween('created_at', array($from, $to))
            ->whereIn('creator_id' ,$childs_id)
            ->latest()
            ->paginate(200);
        }
        
        return view('layouts.marketFeedbacks.index' , compact('marketFeedbacks'));
    }


    public function create()
    {
        $doctors= Doctor::where('created_by' , auth()->user()->id)->get();
        $products= Product::all();
        return view('layouts.marketFeedbacks.create' , compact('doctors' , 'products'));
    }


    public function store(Request $request)
    {   
        $feedback_type='';
        foreach($request->feedback_type as $index=> $value){
            if($index==0){
                $feedback_type .= $value;
            }else{
                $feedback_type .= '/'.$value;
            }
        }


        $products='';
        foreach($request->products as $index=> $value){
            if($index==0){
                $products .= $value;
            }else{
                $products .= '/'.$value;
            }
        }



        $data=$request->except(['product']);
        $data['creator_id'] = auth()->user()->id;
        $data['feedback_type'] = $feedback_type;
        $data['products'] = $products;

        $marketFeedback=MarketFeedback::create($data);

        session()->flash('success','the market feedback has been added successfuly'); 
        return redirect()->route('marketFeedbacks.index');
    }

    public function show(MarketFeedback $marketFeedback)
    {
        $feedbackData=MarketFeedback::where('id' , $marketFeedback->id)->get()[0];
        $products=explode("/",$feedbackData->products);
        $feedbackType=explode("/",$feedbackData->feedback_type);
        $doctor= Doctor::with('addresses')->where('id' , $feedbackData->doctor_id)->get()[0];
        $creator=User::with('parent')->where('id' , $marketFeedback->creator_id)->get()[0];
        $district_manager=User::with('areas')->where('id' , $creator->parent->parent_id)->get()[0];

        // return $weekData;
        return view('layouts.marketFeedbacks.show' , compact('feedbackType' , 'doctor' , 'products' , 'feedbackData' , 'creator' , 'district_manager'));
    }


    public function edit(MarketFeedback $marketFeedback)
    {
        //
    }

    public function update(Request $request, MarketFeedback $marketFeedback)
    {
        //
    }

    public function destroy(MarketFeedback $marketFeedback)
    {
        MarketFeedback::destroy($marketFeedback->id);


        session()->flash('success','the market feedback has been removed successfuly'); 
        return redirect()->route('marketFeedbacks.index');
    }
}
