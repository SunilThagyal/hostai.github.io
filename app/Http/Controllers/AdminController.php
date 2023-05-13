<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddArchitectRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\ContractorDocument;
use App\Models\Contractor;
use App\Models\User;

use App\Models\UserDocument;
use App\Models\Worker;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $projectmanager = config('constants.project-manager');
        $subcontractor = config('constants.subcontractor');
        $worker = config('constants.worker');
        $authUser = Auth::user();


        if (!is_null($request->dates) && (!Auth::user()->role == $projectmanager)) {
            $dates = explode(' - ', $request->dates);
            $dateFrom = $dates[0];
            $dateTo = $dates[1];
            $architects = User::whereBetween('created_at', [$dateFrom, $dateTo])->where([['role', $projectmanager], ['status', 'Active']])->count();
            $contractors = User::whereBetween('created_at', [$dateFrom, $dateTo])->where([['role', $subcontractor], ['status', 'Active']])->count();
            $workers = User::whereBetween('created_at', [$dateFrom, $dateTo])->where([['role', $worker], ['status', 'Active']])->count();

            return view('admin.dashboard', compact('architects', 'contractors', 'workers'));
        }

        //send count if user is project manager
        if ( in_array(Auth::user()->role , [$projectmanager,config('constants.main-manager')] ) ) {

            $GetContractors =  Contractor::with('user')->where('manager_id', get_parent_manager() )->get();
            $GetWorkers = Worker::with('user')->whereIn('contractor_id', $GetContractors->pluck('user_id'))->get();
            $getcontractors =  Contractor::where('manager_id', get_parent_manager() )->pluck('user_id')->toArray();
            $contractors = Contractor::with('user')->where('is_approved', '1')->whereIn('user_id', $getcontractors)->get()->count();
            $workers = $GetWorkers->count();

            if (!is_null($request->dates) && (Auth::user()->role == $projectmanager)) {
                $dates = explode(' - ', $request->dates);
                $dateFrom = $dates[0];
                $dateTo = $dates[1];
                // $architects = User::whereBetween('created_at', [$dateFrom, $dateTo])->where([['role', $projectmanager], ['status', 'Active']])->count();
                $FilteredContractors =  Contractor::with('user')->where('manager_id', get_parent_manager() )->get()->pluck('user')->whereBetween('created_at', [$dateFrom, $dateTo]);

                $GetWorkers = Worker::with('user')->whereIn('contractor_id', $GetContractors->pluck('user_id'))->get()->pluck('user')->whereBetween('created_at', [$dateFrom, $dateTo]);
                //     $workers = User::whereBetween('created_at', [$dateFrom, $dateTo])->where([['role', $worker], ['status', 'Active']])->count();
                $workers = $GetWorkers->count();
                $contractors = $FilteredContractors->count();

                return view('admin.dashboard', compact('contractors', 'workers'));
            }

            return view('admin.dashboard', compact('contractors', 'workers'));
        }

        $architects = User::where('role', $projectmanager)->count();
        $contractors = Contractor::with('user')->where('is_approved', '1')->get()->count();
        $workers = User::where('role',  $worker)->count();

        // dashboard as contractor
        if (Auth::user()->role == 'subcontractor') {
            $ContractorVerification = Contractor::where('user_id', Auth::user()->id)->firstOrFail();

            //  get documents from contractor documnet table
            $documents = ContractorDocument::with('RejectedDocument')->Where('user_id', Auth::user()->id)->get();

            // get documnet count
            $document_count = ContractorDocument::Where('user_id', Auth::user()->id)->get()->count();

            //get only worker count which is under contractor
            $workers =  Worker::with('user')->where('contractor_id', Auth::user()->id)->get()->count();

            if (!is_null($request->dates)) {
                $dates = explode(' - ', $request->dates);
                $dateFrom = $dates[0];
                $dateTo = $dates[1];

                $GetWorkers = Worker::with('user')->where('contractor_id', Auth::user()->id)->get()->pluck('user')->whereBetween('created_at', [$dateFrom, $dateTo]);

                $workers = $GetWorkers->count();


                return view('admin.dashboard', compact('workers', 'ContractorVerification', 'documents'));
            }

            return view('admin.dashboard', compact('architects', 'contractors', 'workers', 'ContractorVerification', 'documents', 'document_count'));
        }

        //auth user subcontractor finish here

        return view('admin.dashboard', compact('architects', 'contractors', 'workers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {   
        $userSlug = auth()->user();
        $user = User::with('userDocuments')->where('slug', $userSlug->slug)->firstOrFail();

        return view('admin.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {   
        $user = auth()->user();

        return view('admin.update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $slug)
    {   
        $user = User::where('slug', $slug)->firstOrFail();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|same:confirm_password|min:6|max:32',
        ], [
            'name.required' => 'Please enter the name',
            'email.required' => 'Please enter the email',
            'email.email' => 'This is not a valid email address',
            'email.unique' => 'This email is already taken',
            'password.same' => 'Password doesn\'t match with confirm password',
            'password.min' => 'Password can be vary between 6 to 32 characters long',
            'password.max' => 'Password can be vary between 6 to 32 characters long',
        ]);
        $data = [
            'role' => $user->role,
            'first_name' => $request->name,
            'email' => $request->email,
        ];


        if ($request->has('profile_pic')) {
            $profile = $request->file('profile_pic');
            $profilePicFile = $profile->getClientOriginalName();
            $profilePicUrl = Storage::disk('public')->put('admin/profilePicture', $profile);
            $data['profile_file'] = $profilePicFile;
            $data['profile_url'] = $profilePicUrl;

            if (!is_null($user->profile_url) && Storage::disk('public')->exists($user->profile_url)) {
                Storage::disk('public')->delete($user->profile_url);
            }
        }

        $user->update($data);

        if ($request->has('certificate')) {


            foreach ($request->certificate as $certificate) {
                $certificateFile = $certificate->getclientOriginalName();
                $certificateUrl = Storage::disk('public')->put('contractor/certificate', $certificate);

                UserDocument::create([
                    'user_id' => $user->id,
                    'uploaded_file_name' =>  $certificateFile,
                    'uploaded_file_url' => $certificateUrl,
                ]);
            }
        }

        return redirect()->route('admin.workers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
    }
}
