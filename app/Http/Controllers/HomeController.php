<?php
namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Role:: firstOrCreate(['name'=>'admin']);
        $role1 = Role:: firstOrCreate(['name'=>'city_manager']);
        $role2 =  Role:: firstOrCreate(['name'=>'gym_manager']);
        $role3 = Role::firstOrCreate(['name'=>'supervisor']);
        $permission = Permission::firstOrCreate(['name' => 'CRUD_training_sessions']);
        $role->givePermissionTo($permission);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $role3->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'assign_coaches_to_sessions']);
        $role2->givePermissionTo($permission);
        $role1->givePermissionTo($permission);
        $role->givePermissionTo($permission);
        $role3->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'buy_sessions_to_users']);
        $role->givePermissionTo($permission);
        $role1->givePermissionTo($permission);
        $role2->givePermissionTo($permission);
        $role3->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'show_city_gyms']);
        $role->givePermissionTo($permission);
        $role1->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'CRUD_gyms']);
        $role->givePermissionTo($permission);
        $role1->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'CRUD_city_gyms_manager']);
        $role->givePermissionTo($permission);
        $role1->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'CRUD_city_managers']);
        $role->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'CRUD_cities']);
        $role->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'attendance']);
        $role->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'revenue']);
        $role->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'CRUD_trainingPackage']);
        $role->givePermissionTo($permission);
        $permission = Permission::firstOrCreate(['name' => 'CRUD_users']);
        $role->givePermissionTo($permission);

        $user=auth()->user();
        $user->assignRole('admin');
        $user->givePermissionTo('CRUD_users');
        $user->givePermissionTo('assign_coaches_to_sessions');
        $user->givePermissionTo('buy_sessions_to_users');
        $user->givePermissionTo('show_city_gyms');
        $user->givePermissionTo('CRUD_gyms');
        $user->givePermissionTo('CRUD_city_gyms_manager');
        $user->givePermissionTo('CRUD_city_managers');
        $user->givePermissionTo('CRUD_cities');
        $user->givePermissionTo('revenue');
        $user->givePermissionTo('attendance');
        $user->givePermissionTo('CRUD_trainingPackage');
        $user->givePermissionTo('CRUD_training_sessions');







        return view('admin/admin');
    }
    public function admin()
    {
        return view('admin/admin');
    }
    public function data()
    {
        return view('admin/data');
    }
    public function buy($request)
    {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys

        \Stripe\Stripe::setApiKey("sk_test_ah8BPqY1IotKT7B8bfbOmQSX00I0BoDobX");
        $data=request()->all();
        $token = $data['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => 999,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
        ]);
        return view('/admin');
    }
    public function show()
    {
        return view('admin/buyPackage');
    }
}
