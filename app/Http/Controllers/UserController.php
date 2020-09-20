<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Area;
use App\area_user;
use App\ParentUserChildUser;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {   

        if(Auth::user()->hasRole('ceo')){
            $users= User::latest()->paginate(200);
        }
        elseif(Auth::user()->hasRole('general_manager')){
            $ceos=User::whereHas('roles', function($q){$q->whereIn('name', ['ceo']);})->get();
            $ceo_id=[];
            foreach($ceos as $index=>$ceo){
                $ceo_id[$index]=$ceo->id;
            }
            $users= User::WhereNotIn('id' , $ceo_id)->latest()->paginate(200);
        }
        elseif(Auth::user()->hasRole('regional_manager')){


            $district_managers_data=ParentUserChildUser::where('parent_id' , Auth::id())->get();
            $district_manager_id=[];
            foreach($district_managers_data as $index=> $distrect_manager){
                $district_manager_id[$index] = $distrect_manager->child_id;
            }

            $childs=ParentUserChildUser::whereIn('parent_id' , $district_manager_id)->get();
            $child_ids=[];
            foreach($childs as $index=> $child){
                $child_ids[$index] = $child->child_id;
            }

            $users= User::whereIn('id' , array_merge($child_ids , $district_manager_id))->latest()->paginate(200);

        }
        elseif(Auth::user()->hasRole('district_manager')){
            $childs=ParentUserChildUser::where('parent_id' , auth()->user()->id)->get();
            $child_ids=[];
            foreach($childs as $index=> $child){
                $child_ids[$index] = $child->child_id;
            }
            $users= User::whereIn('id' , $child_ids)->latest()->paginate(200);

        }
        
        


        return view('layouts.users.index' , compact('users'));
    }


    public function create()
    {

       

        $select_childs_id= ParentUserChildUser::all('child_id');
        $childs_id=[];
        foreach($select_childs_id as $index=>$child){
            $childs_id[$index] = $child['child_id'];
        }

        
        $product_specialists = User::whereHas('roles', function($q){$q->whereIn('name', ['product_specialist']);})->whereNotIn('id' , $childs_id)->get();
        $regional_managers = User::whereHas('roles', function($q){$q->whereIn('name', ['regional_manager']);})->get();
        $district_managers['for_regional_manager'] = User::whereHas('roles', function($q){$q->whereIn('name', ['district_manager']);})->whereNotIn('id' , $childs_id)->get();
        $district_managers['for_product_specialist'] = User::whereHas('roles', function($q){$q->whereIn('name', ['district_manager']);})->get();
        
        
        $select_areas_id= area_user::all('area_id');
        $areas_id=[];
        foreach($select_areas_id as $index=>$area){
            $areas_id[$index] = $area['area_id'];
        }
        $areas['product_specialist'] = Area::whereNotIn('id' , $areas_id)->where('for','product_specialist')->get();
        $areas['district_manager'] = Area::whereNotIn('id' , $areas_id)->where('for','district_manager')->get();
        $areas['regional_manager'] = Area::whereNotIn('id' , $areas_id)->where('for','regional_manager')->get();

        // return $areas;

        return view('layouts.users.create' , compact('regional_managers' , 'product_specialists' , 'areas' , 'district_managers' ));
    }

    public function store(Request $request)
    {
        
        
        $request->validate([    // validation values
            'name' => 'required',
            'email' => 'required|unique:users',
            'role' => 'required',
            'password' => 'required|confirmed'
        ]);
        $request_data= $request->except(['password' , 'password_confirmation' , 'role' ]);
        $request_data['password'] = bcrypt($request->password);  
         


        if($request->role=='ceo'){
            $request_data['job_title'] = 'CEO'; 
            $user= User::create($request_data);
            $user->attachRole($request->role);
        }
        if($request->role=='general_manager'){
            $request_data['job_title'] = 'General Manager'; 
            $user= User::create($request_data);
            $user->attachRole($request->role);
        }
        elseif($request->role=='district_manager'){

            $request_data['job_title'] = 'District Manager'; 
            $user= User::create($request_data);
            $user->attachRole($request->role);
            if($request->has('product_specialist')){
                $childs_id=[];
                foreach($request->product_specialist as $index=>$id){
                    $childs_id[$index]= ['parent_id' => $user->id , 'child_id' => $id ];
                }
                DB::table('parent_user_child_users')->insert($childs_id);
            }
            if(!(empty($request->regional_manager))){
                $parent_id= ['parent_id' => $request->regional_manager , 'child_id' => $user->id];
                DB::table('parent_user_child_users')->insert($parent_id);
            }
            if(!(empty($request->area ))){
                foreach($request->area as $area){
                    if(!(empty($area ))){
                        area_user::create(['area_id' => $area , 'user_id' => $user->id ]);
                    }
                }
            }
            
            
        }
        elseif($request->role=='regional_manager'){
            $request_data['job_title'] = 'Regional Manager'; 
            $user= User::create($request_data);
            $user->attachRole($request->role);
            if($request->has('district_managers_for_regional_manager')){
                $childs_id=[];
                foreach($request->district_managers_for_regional_manager as $index=>$id){
                    $childs_id[$index]= ['parent_id' => $user->id , 'child_id' => $id ];
                }
                DB::table('parent_user_child_users')->insert($childs_id);
            }
            
            if(!(empty($request->area ))){
                area_user::create(['area_id' => $request->area , 'user_id' => $user->id ]);
            }
        }
        elseif($request->role=='product_specialist'){
            
            $request_data['job_title'] = $request->job_title; 
            $user= User::create($request_data);
            $user->attachRole($request->role);
            if(!(empty($request->district_manager))){
                $parent_id= ['parent_id' => $request->district_manager , 'child_id' => $user->id];
                DB::table('parent_user_child_users')->insert($parent_id);
            }
            if(!(empty($request->area ))){
                area_user::create(['area_id' => $request->area , 'user_id' => $user->id ]);
            }
            
        }

        


        session()->flash('success','the user has been added successfuly'); 
        return redirect()->route('users.index');
    }

  
    public function show(User $user)
    {
        //
    }


    public function edit(User $user)
    {


        $district_manager_id_for_product_specialist= ParentUserChildUser::where(['child_id' => $user->id])->get();
        $parent_id_for_child_id= ParentUserChildUser::where(['child_id' => $user->id])->get();
        


         $users = User::whereHas('roles', function($q){$q->whereIn('name', ['product_specialist']);})->get();
        $select_user_childs = ParentUserChildUser::where('parent_id' , $user->id)->get();
        $user_child_id=[];
        foreach($select_user_childs as $index=>$child){
            $user_child_id[$index]= $child->child_id;
        }


        $select_all_childs= ParentUserChildUser::all('child_id');
        $all_child_id=[];
        foreach($select_all_childs as $index=>$child){
            $all_child_id[$index] = $child['child_id'];
        }



        $product_specialists = User::whereHas('roles', function($q){$q->whereIn('name', ['product_specialist']);})->get();
        $regional_managers = User::whereHas('roles', function($q){$q->whereIn('name', ['regional_manager']);})->get();
        $district_managers['for_regional_manager'] = User::whereHas('roles', function($q){$q->whereIn('name', ['district_manager']);})->get();
        $district_managers['for_product_specialist'] = User::whereHas('roles', function($q){$q->whereIn('name', ['district_manager']);})->get();
        
        
        $select_areas_id= area_user::all('area_id');
        $areas_id=[];
        foreach($select_areas_id as $index=>$area){
            $areas_id[$index] = $area['area_id'];
        }

        $areas['product_specialist'] = Area::with('user_id')->where('for','product_specialist')->get();
        $areas['district_manager'] = Area::with('user_id')->where('for','district_manager')->get();
        $areas['regional_manager'] = Area::with('user_id')->where('for','regional_manager')->get();

        // return $areas;

        return view('layouts.users.edit' , compact( 'regional_managers' , 'user_child_id' , 'all_child_id' ,  'parent_id_for_child_id' , 'user' , 'product_specialists' , 'areas' , 'district_managers' ));
    }

    public function update(Request $request, User $user)
    { 

        
        $request->validate([    // validation values
            'name' => 'required',
            'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'role' => 'required',
        ]);

        $request_data= [
            'name'=> $request->name,
            'email'=> $request->email,
        ];
        
        
        if($request->role=='ceo'){
            if($user->hasRole('ceo')){
                
            }
            elseif($user->hasRole('general_manager')){
                $user->detachRole('general_manager');
                $user->attachRole('ceo');
            }
            elseif($user->hasRole('regional_manager')){
                $user->detachRole('regional_manager');
                $user->attachRole('ceo');
            }
            elseif($user->hasRole('district_manager')){
                $user->detachRole('district_manager');
                $user->attachRole('ceo');
            }
            elseif($user->hasRole('product_specialist')){
                $user->detachRole('product_specialist');
                $user->attachRole('ceo');
            }
            ParentUserChildUser::where('child_id', $user->id)->delete();
            ParentUserChildUser::where('parent_id', $user->id)->delete();
            area_user::where('user_id', $user->id)->delete();
            
            $request_data['job_title']='CEO';
        }


        elseif($request->role=='general_manager'){
            if($user->hasRole('ceo')){
                $user->detachRole('ceo');
                $user->attachRole('general_manager');
            }
            elseif($user->hasRole('general_manager')){
                
            }
            elseif($user->hasRole('regional_manager')){
                $user->detachRole('regional_manager');
                $user->attachRole('general_manager');
            }
            elseif($user->hasRole('district_manager')){
                $user->detachRole('district_manager');
                $user->attachRole('general_manager');
            }
            elseif($user->hasRole('product_specialist')){
                $user->detachRole('product_specialist');
                $user->attachRole('general_manager');
            }
            ParentUserChildUser::where('child_id', $user->id)->delete();
            ParentUserChildUser::where('parent_id', $user->id)->delete();
            area_user::where('user_id', $user->id)->delete();
            
            $request_data['job_title']='General Manager';
        }


        elseif($request->role=='regional_manager'){
            if($user->hasRole('ceo')){
                $user->detachRole('ceo');
                $user->attachRole('regional_manager');
            }
            elseif($user->hasRole('general_manager')){
                $user->detachRole('general_manager');
                $user->attachRole('regional_manager');
            }
            elseif($user->hasRole('regional_manager')){
                
            }
            elseif($user->hasRole('district_manager')){
                $user->detachRole('district_manager');
                $user->attachRole('regional_manager');
            }
            elseif($user->hasRole('product_specialist')){
                $user->detachRole('product_specialist');
                $user->attachRole('regional_manager');
            }
            ParentUserChildUser::where('child_id', $user->id)->delete();
            ParentUserChildUser::where('parent_id', $user->id)->delete();
            area_user::where('user_id', $user->id)->delete();
            if($request->has('district_managers_for_regional_manager')){
                $childs_id=[];
                foreach($request->district_managers_for_regional_manager as $index=>$id){
                    $childs_id[$index]= ['parent_id' => $user->id , 'child_id' => $id ];
                }
                ParentUserChildUser::insert($childs_id);
            }
            if(!(empty($request->area ))){
                area_user::create(['area_id' => $request->area , 'user_id' => $user->id ]);
            }
            $request_data['job_title']='Regional Managers';
        }



        elseif($request->role=='district_manager'){

            if($user->hasRole('ceo')){
                $user->detachRole('ceo');
                $user->attachRole('district_manager');
            }
            elseif($user->hasRole('general_manager')){
                $user->detachRole('general_manager');
                $user->attachRole('district_manager');
            }
            elseif($user->hasRole('regional_manager')){
                $user->detachRole('regional_manager');
                $user->attachRole('district_manager');
            }
            elseif($user->hasRole('district_manager')){
                
            }
            elseif($user->hasRole('product_specialist')){
                $user->detachRole('product_specialist');
                $user->attachRole('district_manager');
            }

            $request_data['job_title']='District Manager';
            ParentUserChildUser::where('child_id', $user->id)->delete();
            ParentUserChildUser::where('parent_id', $user->id)->delete();
            if($request->has('product_specialist')){
                $childs_id=[];
                foreach($request->product_specialist as $index=>$id){
                    $childs_id[$index]= ['parent_id' => $user->id , 'child_id' => $id ];
                }
                ParentUserChildUser::insert($childs_id);
            }
            if(!(empty($request->regional_manager ))){
                ParentUserChildUser::insert(['parent_id' => $request->regional_manager , 'child_id' => $user->id ]);
            }
            
            area_user::where('user_id', $user->id)->delete();
            if(!(empty($request->area ))){
                foreach($request->area as $area){
                    if(!(empty($area ))){
                        area_user::create(['area_id' => $area , 'user_id' => $user->id ]);
                    }
                }
            }
        }

        elseif($request->role=='product_specialist'){
            if($user->hasRole('ceo')){
                $user->detachRole('ceo');
                $user->attachRole('product_specialist');
            }
            elseif($user->hasRole('general_manager')){
                $user->detachRole('general_manager');
                $user->attachRole('product_specialist');
            }
            elseif($user->hasRole('regional_manager')){
                $user->detachRole('regional_manager');
                $user->attachRole('product_specialist');
            }
            elseif($user->hasRole('district_manager')){
                $user->detachRole('district_manager');
                $user->attachRole('product_specialist');
            }
            elseif($user->hasRole('product_specialist')){
                
            }
            ParentUserChildUser::where('child_id', $user->id)->delete();
            ParentUserChildUser::where('parent_id', $user->id)->delete();
            area_user::where('user_id', $user->id)->delete();
            if(!(empty($request->district_manager))){
                $parent_id= ['parent_id' => $request->district_manager , 'child_id' => $user->id];
                DB::table('parent_user_child_users')->insert($parent_id);
            }
            if(!(empty($request->area ))){
                area_user::create(['area_id' => $request->area , 'user_id' => $user->id ]);
            }
            $request_data['job_title']=$request->job_title;
        }


        
        $user->update($request_data);


        session()->flash('success','the user has been Updated successfuly'); //cearte flash session
        return redirect()->route('users.index');
    }

   
    public function destroy(User $user)
    {
        User::destroy($user->id);
        session()->flash('success','the user has been removed successfuly'); 
        return redirect()->route('users.index');
    }


    public function reset_password($user_id)
    {
        return view('layouts.users.reset_password' , compact('user_id'));
    }

    public function update_password(Request $request , $user_id)
    {
        $request->validate([    // validation values
            'password' => 'required|confirmed'
        ]);
        DB::table('users')->where('id', $user_id) ->update(['password' => bcrypt($request->password)]);
        session()->flash('success','the user password has been Updated successfuly'); //cearte flash session
        return redirect()->route('users.index');
        
    }

    public function allow_plan($user_id)
    {
        DB::table('users')->where('id', $user_id) ->update(['allow_plan' => 'yes']);
        return redirect()->route('users.index');
    }

    public function disable_plan($user_id)
    {
        DB::table('users')->where('id', $user_id) ->update(['allow_plan' => null]);
        return redirect()->route('users.index');
    }
}
