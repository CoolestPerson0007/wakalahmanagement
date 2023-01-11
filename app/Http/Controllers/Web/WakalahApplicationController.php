<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\RolesController;
use App\Http\Controllers\Controller;
 
use App\Http\Requests\CreateWakalah;
use App\Role;
use App\Support\Enum\UserStatus;
use App\User;
use App\WakalahApplication;
use App\ViewApplicationModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
// This is the wakalah controller file;
class WakalahApplicationController extends Controller
{
    public function show()
    {
        return view('layouts.wakalah_application');
    }
    public function list()
    {
        $wakalahApplication = WakalahApplication::paginate(10);
        return view('layouts.check_application', compact('wakalahApplication'));
    }


    public function view(WakalahApplication $wakalahApplication)
    {


        return view('layouts.view_application', compact('wakalahApplication'));
    }

    public function wakalah_application()
    {
        return view('layouts.wakalah_application');
    }

    // public function view_application(ViewApplicationModel $wakalahApplication)
    // {
    //     return view('layouts.view_application');
    // }
    //isset Message     

    public function approve(Request $request, WakalahApplication $wakalahApplication)
    {
        $wakalahApplication->update($request->except('files5')+[
            'status_id' => 1,
            'wakalah_id'=>$request->wakalah_id,
            'affiliate_link'=>$request->affiliate_link,
            'approval_by'=>auth()->user()->id,
            'approval_at'=>Carbon::now(),
        ]);
        $wakalahApplication->addMediaFromRequest('files5')
        ->toMediaCollection('Appointment Letter');

        $admin = Role::where('name', 'Admin')->first();
         User::create([
            'first_name'=>$wakalahApplication->first_name,
            'last_name'=>$wakalahApplication->last_name,
            'email' =>$wakalahApplication->email,
            'ic_number' =>$wakalahApplication->ic_number,
            'wakalah_id'=>$request->wakalah_id,
            'affiliate_link'=>$request->affiliate_link,
            'phone' =>$wakalahApplication->phone,
            'wakalah_type' =>$wakalahApplication->wakalah_type,
            'institution_name' =>$wakalahApplication->institution_name,
            'address' =>$wakalahApplication->address,
            'city' =>$wakalahApplication->city,
            'state' =>$wakalahApplication->state,
            'zip' =>$wakalahApplication->zip,
            'bank_name' =>$wakalahApplication->bank_name,
            'bank_account' =>$wakalahApplication->bank_account,
            'username' => 'user',
            'password' => 'user123',
            'hash' => sha1('user@example.com'),
            'avatar' => null,
            'role_id' => $admin->id,
            'status' => UserStatus::ACTIVE
        ]);

        return redirect()->route('va',  $wakalahApplication->id)
            ->with('success', 'Wakalah Application Approved');
    }


    

    public function reject(Request $request, WakalahApplication $wakalahApplication)
    {
        $wakalahApplication->update($request->all()+[
            'status_id' => 2,
            'rejection_reason' =>$request->rejection_reason,
            'approval_by'=>auth()->user()->id,
            'approval_at'=>Carbon::now(),
        ]);

        return redirect()->route('va',  $wakalahApplication->id)
            ->with('success', 'Wakalah Application Rejected');
    }


    public function store(CreateWakalah $request)
    {
        $wakalahApplication = WakalahApplication::create($request->except(['files1', 'files2', 'files3', 'files4']) + ['submitted_at' => Carbon::now()]);
 
            $wakalahApplication->addMediaFromRequest('files1')
                ->toMediaCollection('IC');
            $wakalahApplication->addMediaFromRequest('files2')
                ->toMediaCollection('Photo');
            $wakalahApplication->addMediaFromRequest('files3')
                ->toMediaCollection('Bank Statement');
            $wakalahApplication->addMediaFromRequest('files4')
                ->toMediaCollection('Payment Receipt');
        





        // return redirect()->back()->withErrors('Problem Occured!');
        return redirect()->back()->withSuccess('Wakalah Application Successful');
    }
}
