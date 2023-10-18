<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests\Staff\StaffCreateRequest;
use App\Http\Requests\Staff\StaffUpdateRequest;
use App\Models\Address;
use App\Models\Role;
use App\Models\User;
use App\Rules\MatchOldPassword;
use App\Rules\TitleValidationRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        //
        abort_if(Gate::denies('staff_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::orderBy('id','asc')->get();
        return $dataTable->render('admin.staff.index',compact('roles'));
    }

    public function create(){
        $roles = Role::orderBy('id','asc')->get();
        //dd($roles);
        //return view('admin.staff.create',compact('roles'));
        $htmlView = view('admin.staff.create', compact('roles'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffCreateRequest $request)
    {
        $role_id= $request->role_id;
        $data= [
            'name'=>ucwords($request->name),
            'username'=>$request->username,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'created_by'=>Auth::user()->id,
        ];
        //dd($data);

        $user=User::create($data);
        $user->assignRole($role_id);

        return response()->json(['success' => true,
        'message' => trans('messages.crud.add_record'),
        'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //dd($id);
        $user = User::findOrFail($id);
        $roles = Role::all();
        $htmlView = view('admin.staff.edit', compact('roles','user'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffUpdateRequest $request, User $staff)
    {
        $role_id= $request->role_id;
        $staff->update($request->all());
        $staff->assignRole($role_id);

        return response()->json(['success' => true,
        'message' => trans('messages.crud.update_record'),
        'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }

    public function staffpassword(string $id){
        $user = User::findOrFail($id);
        $htmlView = view('admin.staff.change-password', compact('user'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    public function staffUpdatePass(Request $request, string $id){

        $validated = $request->validate([
            'password'   => ['required', 'string', 'min:8','confirmed', 'different:currentpassword'],
            'password_confirmation' => ['required','min:8','same:password'],

        ], getCommonValidationRuleMsgs());

        User::find($id)->update(['password'=> Hash::make($request->password)]);
        return response()->json(['success' => true,
        'message' => trans('passwords.reset'),
        'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function showprofile(){

        abort_if(Gate::denies('profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $addresses = Address::all();
        $user = auth()->user();
       // $user = Auth::user();
      //dd($user->username);
        return view('admin.profile.show', compact('addresses','user'));
    }

    public function updateprofile(Request $request){

        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => ['required','string','unique:users,name,'.$user->id, new TitleValidationRule],
            'username' => ['required','string','max:40','unique:users,username,'.$user->id],
            'email' => ['required','email','unique:users,email,' . $user->id],
            'phone' => ['required','digits:10','numeric'],
            'address_id' => ['required','numeric'],
        ]);
        //dd($validatedData);
        $user->update($validatedData);

        return response()->json(['success' => true,
        'message' => trans('messages.crud.update_record'),
        'title'=> trans('quickadmin.profile.profile'),
        'alert-type'=> trans('quickadmin.alert-type.success')
        ], 200);

    }

    public function updateprofileImage(Request $request){
        $request->validate([
            'profile_image' => 'image|max:1024|mimes:jpeg,png,gif',
        ]);
        $user = auth()->user();
        $actionType = 'save';
        $uploadId = null;
        if($profileImageRecord = $user->profileImage){
            $uploadId = $profileImageRecord->id;
            $actionType = 'update';
        }
        //dd($user, $request->profile_image,$actionType, $uploadId);
        $response = uploadImage($user, $request->profile_image, 'user/profile-images',"profile", 'original', $actionType, $uploadId);

        return response()->json(['success' => true,
        'message' => trans('messages.crud.update_record'),
        'title'=> trans('quickadmin.profile.profile'),
        'alert-type'=> trans('quickadmin.alert-type.success')
        ], 200);
    }

    public function showchangepassform(){
        return view('admin.profile.change-password');
    }

    public function updatePassword(Request $request){
        //dd($request->all());
        $userId = auth()->user()->id;

        $validated = $request->validate([
            'currentpassword'  => ['required', 'string','min:8',new MatchOldPassword],
            'password'   => ['required', 'string', 'min:8','confirmed', 'different:currentpassword'],
            'password_confirmation' => ['required','min:8','same:password'],

        ], getCommonValidationRuleMsgs());

        User::find($userId)->update(['password'=> Hash::make($request->password)]);
        return redirect()->back()->with(['success' => true,
        'message' => trans('passwords.reset'),
        'title'=> trans('quickadmin.profile.fields.password'),
        'alert-type'=> trans('quickadmin.alert-type.success')]);
    }

    public function destroy(string $id)
    {
        abort_if(Gate::denies('staff_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true,
         'message' => trans('messages.crud.delete_record'),
         'alert-type'=> trans('quickadmin.alert-type.success'),
         'title' => trans('quickadmin.users.users')
        ], 200);
    }
}
