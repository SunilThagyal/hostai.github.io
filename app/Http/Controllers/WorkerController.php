<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWorkerRequest;
use App\Http\Requests\WorkerRequest;
use App\Imports\UsersImport;
use App\Models\{Contractor, EmailTemplate, User, UserDocument, Worker};
use App\Notifications\CommonNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Storage};
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $worker = config('constants.worker');
        $admin = config('constants.admin');
        $subContractor = config('constants.subcontractor');
        $projectmanager = config('constants.project-manager');

        // if auth is admin


        $authUser = Auth::user();
        if ($admin == $authUser->role)
        {
            $users = Worker::with('user')->with('workerContractor')
            ->when(!is_null($request->search), function($q) use($request) {
                $q->whereHas('user', function($query) use($request) {
                    $query->where('first_name', 'like', '%' . $request->search . '%');
                });
            })->orderByDesc('user_id')->get();

            return view('admin.worker.workers', compact('users'));
        }
        else if( in_array($authUser->role , [$projectmanager ,config('constants.main-manager') ] ) )
        {
            $contractors =  Worker::where('manager_id', get_parent_manager() )->get();
            $workers = Worker::with('user')->with('workerContractor.contractor')->whereIn('contractor_id', $contractors->pluck('contractor_id'))
            ->when(!is_null($request->search), function($q) use($request) {
                $q->whereHas('user', function($query) use($request) {
                    $query->where('first_name', 'like', '%' . $request->search . '%');
                });
            })->orderByDesc('user_id')->get();

            return view('admin.worker.workers', compact('workers'));
        }
        else if ($authUser->role == $subContractor)
        {
            $workers =  Worker::with('user')->where('contractor_id', $authUser->id)
            ->when(!is_null($request->search), function($q) use($request) {
                $q->whereHas('user', function($query) use($request) {
                    $query->where('first_name', 'like', '%' . $request->search . '%');
                });
            })->orderByDesc('user_id')->get();

            return view('admin.worker.workers', compact('workers'));
        }

        return redirect()->route($authUser->role . '.dashboard');

}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $contractors = [];
        if( in_array( auth()->user()->role , [config('constants.main-manager'),config('constants.project-manager')] ) ){
            $user = User::find( get_parent_manager() );
            $contractors = Contractor::with('user')->where('manager_id', get_parent_manager())->where('is_approved', '1')->get();
        }
        $user->load(['userSites.site']);
        return view('admin.worker.add', compact('user','contractors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkerRequest $request)
    {
        $worker = config('constants.worker');
        $authUser = Auth::user();
        $data = [
            'role' => $worker,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?? null,
            'status' => 'Active',
        ];
        

        if ($request->has('profile_pic')) {
            $profile = $request->file('profile_pic');
            $profilePicFile = $profile->getClientOriginalName();
            $profilePicUrl = Storage::disk('public')->put('worker/profilePicture', $profile);
            $data['profile_file'] = $profilePicFile;
            $data['profile_url'] = $profilePicUrl;
        }
        DB::beginTransaction();
        $user = User::create($data);
        $user->workerSite()->create([
            'user_id' => $user->id,
            'site_id' => $request->construction_site,
        ]);
        //

        foreach ($request->document_name as $index => $documentName) {
            $data = [
                'user_id' => $user->id,
                'document_name' => $documentName,
                'valid_between' => $request->dates[$index],
            ];
            if (isset($request->certificate[$index]) && $request->hasFile('certificate.' . $index)) {
                $certificate = $request->certificate[$index];
                $certificateFile = $certificate->getclientOriginalName();
                $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
                $data['uploaded_file_name'] =  $certificateFile;
                $data['uploaded_file_url'] = $certificateUrl;
                $data['document_type'] = 'safety';
            }
            $workerNewDocuments[] = $data;
        }
        
        if (count($workerNewDocuments)) {
            UserDocument::insert($workerNewDocuments);
        }

        //
        foreach ($request->admin_document_name as $index => $documentName) {
            $data = [
                'user_id' => $user->id,
                'document_name' => $documentName,
                'valid_between' => $request->admin_dates[$index],
            ];
            if (isset($request->admin_certificate[$index]) && $request->hasFile('admin_certificate.' . $index)) {
                $certificate = $request->admin_certificate[$index];
                $certificateFile = $certificate->getclientOriginalName();
                $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
                $data['uploaded_file_name'] =  $certificateFile;
                $data['uploaded_file_url'] = $certificateUrl;
                $data['document_type'] = 'administrative';
            }
            $workerAdminDocuments[] = $data;
        }

        if (count($workerAdminDocuments)) {
            UserDocument::insert($workerAdminDocuments);
        }
        // administrative docs

        // $managerId = Contractor::where('user_id', $authUser->id )->firstOrFail();
        // $worker = ['contractor_id' => $request->has('workerof') ? Request('workerof') : $authUser->id];

        // @dd($worker,$authUser->id,$authUser->role);
        $worker = [
            'user_id' => $user->id,
            'manager_id' => get_parent_manager(),
            'contractor_id' => $request->has('workerof') ? $request->workerof : $authUser->id,
            'employment_type' => $request->employment_type,
        ];
        Worker::create($worker);
        DB::commit();
        return redirect()->route(auth()->user()->role.'.workers')->with(['status' => 'success', 'message' => 'Worker added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::with('userSites.site', 'safetyDocuments','adminDocuments','Worker.workerContractor.contractor','Worker.architect')->where('slug', $slug)->firstOrFail();
        $url = url('worker/'.$slug.'/show');

        return view('admin.worker.view', compact('user', 'url'));
    }

    public function showOnScan($slug)
    {
        $user = User::with('userSites.site', 'userDocuments', 'Worker.workerContractor', 'Worker.architect')->where('slug', $slug)->firstOrFail();

        return view('view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $contractor = auth()->user();
        $getContractors = [];
        if( in_array( auth()->user()->role , [config('constants.main-manager'),config('constants.project-manager')] ) ){
            $contractor = User::find( get_parent_manager() );
            $getContractors = Contractor::with('user')->where('manager_id', get_parent_manager())->where('is_approved', '1')->get();
        }
        $contractor->load(['userSites.site']);
        $worker = User::with('workerSite', 'safetyDocuments', 'adminDocuments' , 'Worker.workerContractor', 'Worker.architect')->where('slug', $slug)->firstOrFail();

        return view('admin.worker.update', compact('contractor', 'worker','getContractors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkerRequest $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?? nUll,
            // 'location' => $request->location,
        ];

        if ($request->has('profile_pic')) {
            $profile = $request->file('profile_pic');
            $profilePicFile = $profile->getClientOriginalName();
            $profilePicUrl = Storage::disk('public')->put('worker/profilePicture', $profile);
            $data['profile_file'] = $profilePicFile;
            $data['profile_url'] = $profilePicUrl;

            if (!is_null($user->profile_url) && Storage::disk('public')->exists($user->profile_url)) {
                Storage::disk('public')->delete($user->profile_url);
            }
        }
        $user->update($data);

        $user->workerSite()->updateOrCreate([
            'user_id' => $user->id
        ], [
            'site_id' => $request->construction_site,
        ]);

        $isApproved = false;
        $workerNewDocuments = [];
        $oldCertificateKeys = isset($request->old_certificate) ? array_keys($request->old_certificate) : [];
        foreach ($request->document_name as $index => $documentName) {
            $data = [
                'user_id' => $user->id,
                'document_name' => $documentName,
                'valid_between' => $request->dates[$index],
                'uploaded_file_name' => $request->old_certificate_name[$index] ?? null,
                'uploaded_file_url' => $request->old_certificate_url[$index] ?? null,
            ];
            if (isset($request->certificate[$index]) && $request->hasFile('certificate.' . $index)) {
                $certificate = $request->certificate[$index];
                $certificateFile = $certificate->getclientOriginalName();
                $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
                $data['uploaded_file_name'] =  $certificateFile;
                $data['uploaded_file_url'] = $certificateUrl;
                $data['document_type'] = 'safety';
                $isApproved = true;

            }
            if (in_array($index, $oldCertificateKeys) && !is_null($request->old_certificate[$index])) {
                UserDocument::where('id', $request->old_certificate[$index])->where('user_id', $user->id)->update($data);
                $reset_status = true;
            } else {
                $workerNewDocuments[] = $data;
            }
        }
        if (count($workerNewDocuments)) {
            UserDocument::insert($workerNewDocuments);
            $isApproved = true;
        }

        //
        $workerNewAdminDocuments = [];
        $oldAdminCertificateKeys = isset($request->old_admin_certificate) ? array_keys($request->old_admin_certificate) : [];

        foreach ($request->admin_document_name as $index => $documentName) {
            $data = [
                'user_id' => $user->id,
                'document_name' => $documentName,
                'valid_between' => $request->admin_dates[$index] ?? null,
                'uploaded_file_name' => $request->old_admin_certificate_name[$index] ?? null,
                'uploaded_file_url' => $request->old_admin_certificate_url[$index] ?? null,
            ];
            if (isset($request->admin_certificate[$index]) && $request->hasFile('admin_certificate.' . $index)) {
                $certificate = $request->admin_certificate[$index];
                $certificateFile = $certificate->getclientOriginalName();
                $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
                $data['uploaded_file_name'] =  $certificateFile;
                $data['uploaded_file_url'] = $certificateUrl;
                $data['document_type'] = 'administrative';
                $isApproved = true;
            }
            if (in_array($index, $oldAdminCertificateKeys) && !is_null($request->old_admin_certificate[$index])) {
                $admin=UserDocument::where('id', $request->old_admin_certificate[$index])->where('user_id', $user->id)->update($data);
                $reset_status = true;
            } else {
                $workerNewAdminDocuments[] = $data;
            }
        }
        if (count($workerNewAdminDocuments)) {
            UserDocument::insert($workerNewAdminDocuments);
            $isApproved = true;
        }
        // worker table employement type 
        if($request->has('employment_type'))
        {
            Worker::where('user_id',$user->id)->update(['employment_type' => $request->employment_type]);
        }
        
        Worker::where('user_id',$user->id)->update([
            'contractor_id' => $request->has('workerof') ? $request->workerof : $authUser->id
        ]);
        // reset status of worker
        if($isApproved == true)
        {
            Worker::where('user_id',$user->id)->update([
                'is_approved' => NULL,
                'approved_by' => NULL,
                
                'remark' => NULL,
            ]);
        }

        //
        return redirect()->route(auth()->user()->role.'.workers')->with(['status' => 'success', 'message' => 'Worker update successfully']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $user->Worker()->delete();
        $user->delete();

        return redirect()->route( auth()->user()->role.'.workers')->with(['status' => 'success', 'message' => 'Worker deleted successfully']);
    }
    public function uploadcsv()
    {
        $projectmanager = config('constants.project-manager');
        $subcontractor = config('constants.subcontractor');
        $mainManager = config('constants.main-manager');
        $authUser = Auth::user();
        $contractors = [];
        if ($authUser->role == $projectmanager) {
            $architects = User::where(['status' => 'Active', 'slug' => $authUser->slug])->get();
        } else {
            $architects = User::where(['role' => $projectmanager, 'status' => 'Active'])->get();
        }

        if($authUser->role == $mainManager || $authUser->role == $projectmanager ){
            $contractors = Contractor::with('user')->where('manager_id', get_parent_manager())->where('is_approved', '1')->get();
        }

        $contractorSites = '';
        if ($authUser->role == $subcontractor) {
            $contractorSites = User::with('userSites.site')->where('slug', $authUser->slug)->get()->toArray();
        }

        return view('admin.worker.addcsv', compact('authUser', 'architects', 'contractors'));
    }

    public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt',
    ], [
        'csv_file.required' => 'Please upload the csv file',
        'csv_file.mimes' => 'file should be csv only'
    ]);

    try {
        Excel::import(new UsersImport, request()->file('csv_file'));
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();

        return redirect()->route(auth()->user()->role.'.workers')->with(['status' => 'danger', 'message' => $e->getMessage(), 'failures' => $failures]);
    } catch (\Exception $e) {
        return redirect()->route(auth()->user()->role.'.workers')->with(['status' => 'danger', 'message' => $e->getMessage()]);
    }

    return redirect()->route(auth()->user()->role.'.workers')->with(['status' => 'success', 'message' => 'Data imported successfully']);
}


    public function deleteDocument(Request $request)
    {
        try {
            $user = Auth::user();
            $document = UserDocument::where('user_id', $request->worker_id)->where('id', $request->id)->firstOrFail();

            if (!is_null($document)) {
                $document->delete();
            }

            return response()->json([
                'status' => true,
                'message' => 'Document deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 401);
        }
    }
    /**
     * accept worker so that QR  start working.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept($slug)
    {
        try
        {
            $user = User::where('slug', $slug)->firstOrFail();
            $managerId = auth()->id();
            Worker::where('user_id',$user->id)->update([
                'approved_by' => $managerId,
                'is_approved' => '1',
            ]);
            $response = ['status' => 'success', 'message' => 'Worker has been accepted  successfully'];
            return back()->with($response);
        }
        catch(\Exception $e)
    {   
        $response = ['status' => 'danger', 'message' => 'No matching record found'];
        return back()->with($response);
    }
    
    }

    /**
     * reject a specific  worker.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject( $slug)
    {   
        DB::beginTransaction();
        try
        {
            $user = User::where('slug', $slug)->firstOrFail();
            $managerId = auth()->id();
            $managerName = auth()->user()->first_name;
            $worker = Worker::with('workerContractor')->where('user_id',$user->id)->firstOrFail();
            $contractor = $worker->workerContractor;
            Worker::where('user_id',$user->id)->update([
                'approved_by' => $managerId,
                'is_approved' => '0',
                'remark' => request('remark')
            ]);
            
            // 
            $template = EmailTemplate::where('slug', 'reject-worker')->first();
            if (!is_null($template)) {
                $strReplace = [
                    '[APP_NAME]',
                    '[CONTRACTOR]',
                    '[WORKER]',
                    '[MAIN_CONTRACTOR]',
                    '[IMG]',
                    '[REMARK]',
                    '[LOGIN]',
                ];
                $strReplaceWith = [
                    config('app.name'),
                    $contractor->first_name,
                    $user->first_name,
                    $managerName,
                    asset('images/reject.png'),
                    request('remark'),
                    route('login'),
                ];
                $subject = str_replace($strReplace, $strReplaceWith, $template->subject);
                $content = str_replace($strReplace, $strReplaceWith, $template->content);
                $data = [
                    'subject' => $subject,
                    'content' => $content,
                ];
                $contractor->notify(new CommonNotification($data));
            }
            // 
            DB::commit();
            $response = ['status' => 'danger', 'message' => 'Worker has been rejected  successfully'];
            return back()->with($response);
        }
        catch (\Exception $e)
        {
            $response = ['status' => 'danger', 'message' => 'Error occurred while rejecting'];
        return back()->with($response);
        }
    
    }

}
