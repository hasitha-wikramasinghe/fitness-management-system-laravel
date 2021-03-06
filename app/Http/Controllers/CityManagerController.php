<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\CityManager\StoreCityManagerRequest;
use App\Http\Requests\CityManager\UpdateCityManagerRequest;
use Illuminate\Support\Facades\Storage;
use App\City;


class CityManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return datatables()->of(User::query()->role("admin"))->toJson(); // changed city manager as admin
    }

    public function index_view()
    {
//        $data=datatables()->of(User::query())->toJson();
//        return $data;
        return view(
            'admin/data'
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $cities = City::all();  // dont need cities // ,['cities' => $cities,] 
        return view('/managers/CityManagerCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityManagerRequest $request)
    {
        if ($request->hasFile("avatar_image")) {
            $path = Storage::putFile('public/avatar_image', $request->file('avatar_image'));
            $User=User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'avatar_image'=>basename($path),
            // 'city_id'=>$request['city_id'],
            ]);
        } elseif (! $request->hasFile("avatar_image")) {
            $User=User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            // 'city_id'=>$request['city_id'],
             ]);
        }
        $User->assignRole('admin'); // changed city manager to admin
        $User->givePermissionTo('CRUD_training_sessions');
        $User->givePermissionTo('assign_coaches_to_sessions');
        $User->givePermissionTo('buy_sessions_to_users');
        $User->givePermissionTo('show_city_gyms');
        $User->givePermissionTo('CRUD_gyms');
        $User->givePermissionTo('CRUD_city_gyms_manager');



        return redirect()->route('CityManager.store')->with('message', 'Created Successfully!');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city_manager = User::findorfail($id);
        $ban=$city_manager->isBanned();
        $unban=$city_manager->isNotBanned();
        return view("managers/ManagerShow", [
            'manager'=>$city_manager,
            'bann'=>$ban,
            'unban'=>$unban,
            'city'=>$city_manager->city_id,
            
        ]);
    }
    public function ban($id)
    {
     
        $city_manager = User::findorfail($id);
        
        $sban=$city_manager->ban();

        return redirect()->route('CityManager.index_view');
    }
    public function unban($id)
    {
        $city_manager = User::findorfail($id);
        $city_manager->unban();
        return redirect()->route('CityManager.index_view');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city_manager = User::find($id);
        return view('/managers/CityManagerEdit', [
                'city_manager'=>$city_manager
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityManagerRequest $request, $id)
    {
        $city_manager = User::findorfail($id);
        if ($request->hasFile("avatar_image")) {
            $path = Storage::putFile('public/avatar_image', $request->file('avatar_image'));
            $city_manager->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'avatar_image'=>basename($path),
            'city_id'=>$request['city_id'],
            ]);
        } elseif (! $request->hasFile("avatar_image")) {
            $city_manager->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'city_id'=>$request['city_id'],
             ]);
        }
        return redirect()->route('CityManager.index_view')->with('message', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return view('admin/admin');
    }
}
