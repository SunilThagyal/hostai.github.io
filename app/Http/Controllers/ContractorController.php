<?php

namespace App\Http\Controllers;

use App\Events\ContractorWelcome;
use App\Http\Requests\{AddContractorRequest, SubcontractorDocumentRequest, ContractorDocumentsRequest, RejectDocumentRequest};
use App\Models\{ContractorDocument, Contractor, EmailTemplate, Manager, RejectedDocuments, Site, User, UserSite};
use App\Notifications\CommonNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Storage};

class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projectmanager = config('constants.project-manager');
        $editableManager = config('constants.main-manager');
        $authUser = Auth::user();
        if ($authUser->role == 'admin') {
            $unapproved_contractors = Contractor::where(['document_status' => 'submitted'])->count();
            $pending_contractors = Contractor::with('user')->with('architect')->where('is_approved', '0')->where('document_status', '!=', 'rejected')->count();
            $contractors = Contractor::with('user')
            ->where('document_status','!=','rejected')
            ->when(!is_null($request->search), function($q) use($request) {
                $q->whereHas('user', function($query) use($request) {
                    $query->where('first_name', 'like', '%' . $request->search . '%');
                });
            })->orderByDesc('user_id')->get();
            // @dd($contractors);
            return view('admin.contractor.contractors', compact('contractors', 'unapproved_contractors', 'pending_contractors'));
        } else if ( in_array($authUser->role,[$projectmanager,$editableManager]) ) {
            $unapproved_contractors = Contractor::where(['document_status' => 'submitted'])->managerCheck()->count();
            $pending_contractors = Contractor::with('user')->where('is_approved', '0')->where('document_status', '!=', 'rejected')->managerCheck()->count();
            $contractors =  Contractor::with('user')
            ->managerCheck()
            ->where('document_status','!=','rejected')
            ->when(!is_null($request->search), function($q) use($request) {
                $q->whereHas('user', function($query) use($request) {
                    $query->where('first_name', 'like', '%' . $request->search . '%');
                });
            })->orderByDesc('user_id')->get();

            return view('admin.contractor.contractors', compact('contractors', 'unapproved_contractors', 'pending_contractors'));
        }

        return redirect()->route($authUser->role . '.dashboard');
    }


    public function unverified()
    {
        if (Auth::user()->role == 'admin') {
            $users = Contractor::with('unapprovedContractors')->where('is_approved', '0')->where('document_status', '!=', 'rejected')->get();
        } else {
            $users = Contractor::with('unapprovedContractors')->where('is_approved', '0')->where('document_status', '!=', 'rejected')->managerCheck()->get();
        }

        return view('admin.contractor.unaprrovedContractor', compact('users'));
    }

    public function approveindex()
    {
        if (Auth::user()->role == 'admin') {
            $users = Contractor::with('unapprovedContractors')->where('document_status', 'submitted')->get();
        } else {
            $users = Contractor::with('unapprovedContractors')->where('document_status', 'submitted')->where('manager_id', auth()->user()->id)->get();
        }

        $users->toArray();

        return view('admin.contractor.requestedContractors', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin = config('constants.admin');
        $projectmanager = config('constants.project-manager');
        $editableManager = config('constants.main-manager');
        $authUser = Auth::user();
        $projectManagers = [];
        $sites = [];
        $main_contractors = [];
        if ($authUser->role == $admin) {
            $projectManagers = User::where(['status' => 'Active', 'role' => $projectmanager])->get();
        }

        if ($authUser->role == $projectmanager) {
            $sites = $authUser->load(['userSites.site']);
            $main_contractors = Contractor::with('user')->where('is_approved','1')->where('manager_id',$authUser->id)->whereNull('contractor_id')->get()->pluck('user');

        }

        if ($authUser->role == $editableManager) {
            $managers = User::with('assignedManagers')->where('id',$authUser->id)->first();
            $ManagerDetails = User::where('id',$managers->assignedManagers->project_manager_id)->first();
            // dd($ManagerDetails->load(['userSites.site']));
            $sites = $ManagerDetails->load(['userSites.site']);
            // dd($sites);
            $main_contractors = Contractor::with('user')->where('is_approved','1')->where('manager_id',$ManagerDetails->id)->whereNull('contractor_id')->get()->pluck('user');


        }

        return view('admin.contractor.add', compact('projectManagers', 'sites', 'main_contractors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requestwu
     * @return \Illuminate\Http\Response
     */
    public function store(AddContractorRequest $request)
    {
        DB::beginTransaction();
        try {
            $subcontractor = config('constants.subcontractor');
            $projectManager = config('constants.project-manager');
            $editableManager = config('constants.main-manager');
            $data = [
                'role' => $subcontractor,
                'first_name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'location' => $request->location,
            ];

            if ($request->has('profile_pic')) {
                $profile = $request->file('profile_pic');
                $profilePicFile = $profile->getClientOriginalName();
                $profilePicUrl = Storage::disk('public')->put('worker/profilePicture', $profile);
                $data['profile_file'] = $profilePicFile;
                $data['profile_url'] = $profilePicUrl;
            }
            $managerId = isset($request->architect_id) ? $request->architect_id : get_parent_manager();
            $user = User::create($data);

            $contractorDetails =[
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'manager_id' => $managerId,
            ];
            if (!is_null($request->main_contractor))
            {
                $check = Contractor::where('user_id',$request->main_contractor)->where('manager_id',$managerId)->where('is_approved','1')->whereNull('contractor_id')->firstOrFail();
                $contractorDetails['contractor_id'] = $request->main_contractor;
            }

            Contractor::create($contractorDetails);

            $constructionSite = [];
            if (!is_null($request->construction_site)) {
                foreach ($request->construction_site as $site) {
                    $constructionSite[] = [
                        'user_id' => $user->id,
                        'site_id' => $site,
                    ];
                }
            }

            if (count($constructionSite)) {
                UserSite::insert($constructionSite);
            }
            // docs
             //
        foreach ($request->admin_document_name as $index => $documentName) {
            $data = [
                'user_id' => $user->id,
                'status' => 'APPROVED',
                'document_name' => $documentName,
                'valid_between' => $request->admin_dates[$index],
            ];
            if (isset($request->admin_certificate[$index]) && $request->hasFile('admin_certificate.' . $index)) {
                $certificate = $request->admin_certificate[$index];
                $certificateFile = $certificate->getclientOriginalName();
                $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
                $data['uploaded_file_name'] =  $certificateFile;
                $data['uploaded_file_url'] = $certificateUrl;
            }
            $ContractorDocuments[] = $data;
        }

        if (isset($request->admin_certificate[$index]) && $request->hasFile('admin_certificate.' . $index)) {
            // @dd('hello');
            ContractorDocument::insert($ContractorDocuments);
            Contractor::where('user_id', $user->id)->update([
                'document_status' => "approved",
                'is_approved' => '1',
                'approved_by' =>  auth::user()->id,


            ]);

        }
        // administrative docs

            //
            $template = EmailTemplate::where('slug', 'contractor-register')->first();
            $password = $request->password;
            $email = $request->email;
            $manager = User::where('id', $managerId)->firstOrFail();
            $manger_name = $manager->first_name;

            if (!is_null($template)) {
                $strReplace = [
                    '[APP_NAME]',
                    '[MANAGER]',
                    '[IMG1]',
                    '[IMG2]',
                    '[URL]',
                    '[PASSWORD]',
                    '[EMAIL]',
                ];
                $strReplaceWith = [
                    config('app.name'),
                    $manger_name,
                    asset('images/id-verified_hires.png'),
                    asset('images/realtime-protection_hires.png'),
                    route('login'),
                    $password,
                    $email,
                ];
                $subject = str_replace($strReplace, $strReplaceWith, $template->subject);
                $content = str_replace($strReplace, $strReplaceWith, $template->content);
                $data = [
                    'subject' => $subject,
                    'content' => $content,
                ];
                $user->notify(new CommonNotification($data));
            }
            DB::commit();

            return redirect()->route(auth()->user()->role . '.contractors')->with(['status' => 'success', 'message' => 'Subcontractor has been added successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            $response = ['status' => 'danger', 'message' => $e->getMessage()];

            return redirect()->back()->withInput()->with($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::with('userSites.site', 'contractor.architect' ,'contractor.contractorOf')->where('slug', $slug)->firstOrFail();

        if(is_null($user)){
            return redirect()->route(auth()->user()->role . '.contractors');
        }

        $main_contractors = Contractor::with('user')->where('contractor_id',$user->id)->get();
        $documents = ContractorDocument::where('user_id', $user->id)->get();
        return view('admin.contractor.view', compact('user', 'documents' , 'main_contractors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadedDocuments($slug){
        $documents = ContractorDocument::where('user_id',get_userId($slug))->get();
        return view('admin.contractor.documents',compact('documents'));
    }
    public function edit($slug)
    {
        $projectmanager = config('constants.project-manager');
        $sites = [];
        $main_contractors = [];
        $user = User::with('userSites', 'contractor' ,'contractorDocuments')->where('slug', $slug)->firstOrFail();
        $projectManagers = User::where(['role' => $projectmanager, 'status' => 'Active'])->get();
        if ('admin' == Auth::user()->role) {
            $sites = Site::where('status', 'Active')->get();
            $main_contractors = Contractor::with('user')->where('is_approved','1')->where('manager_id',$user->contractor->manager_id)->whereNot('user_id',$user->id)->whereNull('contractor_id')->get()->pluck('user');
        } else{

            $sites = UserSite::with('site')->where('user_id',get_parent_manager() )->get();
            $main_contractors = Contractor::with('user')->where('is_approved','1')->where('manager_id', get_parent_manager() )->whereNot('user_id',$user->id)->whereNull('contractor_id')->get()->pluck('user');

        }
        $constructionSite = [];
        foreach ($user->userSites as $site) {
            $constructionSite[] = $site->site_id;
        }

        return view('admin.contractor.update', compact('user', 'sites', 'projectManagers', 'constructionSite' , 'main_contractors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddContractorRequest $request, $slug)
    {
        DB::beginTransaction();
        try{
        $subcontractor = config('constants.subcontractor');
        $projectmanager = config('constants.project-manager');
        $user = User::with('userSites.site')->where('slug', $slug)->firstOrFail();
        $data = [
            'role' => $subcontractor,
            'first_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location,
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

        if ($request->has('certificate')) {
            $certificate = $request->file('certificate');
            $certificateFile = $certificate->getClientOriginalName();
            $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
            $data['certificate_file'] = $certificateFile;
            $data['certificate_url'] = $certificateUrl;

            if (!is_null($user->certificate_url) && Storage::disk('public')->exists($user->certificate_url)) {
                Storage::disk('public')->delete($user->certificate_url);
            }
        }

        $user->update($data);
        $constructionSite = [];

        if (!is_null($request->construction_site)) {
            UserSite::where('user_id', $user->id)->delete();
            foreach ($request->construction_site as $site) {
                $constructionSite[] = [
                    'user_id' => $user->id,
                    'site_id' => $site,
                ];
            }
        }
        if (count($constructionSite)) {
            UserSite::insert($constructionSite);
        }
        $contractorDetails =[];
        $contractorDetails['company_name'] = $request->company_name;
        if (('admin' == Auth::user()->role) && !is_null($request->architect_id)) {
            // Contractor::where('user_id', $user->id)->update(['manager_id' => $request->architect_id]);
            $contractorDetails['manager_id'] = $request->architect_id;


        }
        if (!is_null($request->main_contractor)) {
            $managerId = isset($request->architect_id) ? $request->architect_id : get_parent_manager();
            $check = Contractor::where('user_id',$request->main_contractor)->where('manager_id',$managerId)->where('is_approved','1')->whereNull('contractor_id')->firstOrFail();

        }
        $contractorDetails['contractor_id'] = $request->main_contractor;
        Contractor::where('user_id', $user->id)->update($contractorDetails);
        //
        $workerNewAdminDocuments = [];
        $oldAdminCertificateKeys = isset($request->old_admin_certificate) ? array_keys($request->old_admin_certificate) : [];

        foreach ($request->admin_document_name as $index => $documentName) {
            $data = [
                'user_id' => $user->id,
                'document_name' => $documentName,
                'valid_between' => $request->admin_dates[$index] ?? null,
                'status'=> 'APPROVED',
                'uploaded_file_name' => $request->old_admin_certificate_name[$index] ?? null,
                'uploaded_file_url' => $request->old_admin_certificate_url[$index] ?? null,
            ];
            if (isset($request->admin_certificate[$index]) && $request->hasFile('admin_certificate.' . $index)) {
                $certificate = $request->admin_certificate[$index];
                $certificateFile = $certificate->getclientOriginalName();
                $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
                $data['uploaded_file_name'] =  $certificateFile;
                $data['uploaded_file_url'] = $certificateUrl;
            }
            if (in_array($index, $oldAdminCertificateKeys) && !is_null($request->old_admin_certificate[$index])) {
                $admin=ContractorDocument::where('id', $request->old_admin_certificate[$index])->where('user_id', $user->id)->update($data);
            } else {
                $workerNewAdminDocuments[] = $data;
            }
        }

        if (count($workerNewAdminDocuments) && isset($request->admin_certificate[$index]) && $request->hasFile('admin_certificate.' . $index)) {
            ContractorDocument::insert($workerNewAdminDocuments);

            $getContractor = Contractor::where('user_id', $user->id);
            $contractor = $getContractor->firstOrFail();
            if(is_null($contractor->approved_by) ) {
                $getContractor->update([
                    'document_status' => "approved",
                    'is_approved' => '1',
                    'approved_by' =>  auth::user()->id
                ]);
            }

        }
        //
        DB::commit();
        return redirect()->route(auth()->user()->role.'.contractors')->with(['status' => 'success', 'message' => 'Subcontractor has been updated successfully']);
        }
        catch (\Exception $e) {
            DB::rollback();
            $response = ['status' => 'danger', 'message' => 'There is some error in form submission'];
            return redirect()->back()->withInput()->with($response);
        }
    }

    public function destroyDocument(Request $request)
    {
        try {
            $user = Auth::user();
            $document = ContractorDocument::where('user_id', $request->contractor_id)->where('id', $request->id)->firstOrFail();

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $contractor_worker = $user->contractorWorkers()->get();
        foreach ($contractor_worker as $worker) {
            //    echo($worker->user_id);
            $get_worker = User::where('id', $worker->user_id);
            $get_worker->delete();
        }
        // dd($contractor_worker);

        // got document of contractors
        $user->contractorDocuments()->delete();
        //got user sites under contractor
        $user->userSites()->delete();
        //delete contractor itself
        $user->delete();

        return back()->with(['status' => 'success', 'message' => 'Contractor has been deleted successfully.']);
    }

    //  document upload for verification
    public function documentsupload(ContractorDocumentsRequest $request, $slug)
    {
        // @dd( $request->all());
        $user = User::where('slug', $slug)->firstOrFail();
        $docs = ContractorDocument::where('user_id',$user->id)->count();
        $status = $request->has('submit') ? 'submitted' : 'draft';
        if($docs + count($request->certificate) < 12)
        {
            if ($request->has('certificate')) {
                $index = 0;
                foreach ($request->document_name as $doc_name) {
                    $certificateFile = $request->certificate[$index]->getclientOriginalName();
                    $certificateUrl = Storage::disk('public')->put('worker/certificate', $request->certificate[$index]);
                    $expiryDate = $request->admin_dates[$index];
                    ContractorDocument::insert([
                        'user_id' => $user->id,
                        'document_name' => $doc_name,
                        'uploaded_file_name' =>  $certificateFile,
                        'uploaded_file_url' => $certificateUrl,
                        'valid_between' => $expiryDate,
                    ]);

                    Contractor::where('user_id', $user->id)->update(['document_status' => $status]);
                    $index++;
                }
            }
            return redirect()->route('admin.dashboard');
        }
        else
        {
            return redirect()->route('admin.dashboard')->with(['status' => 'danger', 'message' => 'you can upload only '. 12 - $docs  .' more documents']);

        }

    }

    public function deleteDocument($id)
    {
        $document = ContractorDocument::where('id', $id)->firstOrFail();
        Storage::disk('public')->delete($document->uploaded_file_url);
        $document->delete();

        return redirect()->route('admin.dashboard');
    }

    public function submitdocument($user_id)
    {
        $document_count = ContractorDocument::Where('user_id', $user_id)->get()->count();
        if ($document_count > 0) {
            Contractor::where('user_id', $user_id)->update([
                'document_status' => 'submitted'
            ]);

            return redirect()->route('admin.dashboard');
        }
    }
    public function ReUploadDocument(Request $request, $docs_id)
    {
        $document = ContractorDocument::where('id', $docs_id)->firstOrFail();
        $request->validateWithBag('document_'.$document->id,[
            'certificate*' => 'mimes:jpeg,pdf,png,jpg|max:2000',
        ],
        [
            'certificate.max' => 'File should  be less than 2MB',

        ]);

        if ($request->has('certificate')) {
            $certificate = $request->file('certificate');
            $certificateFile = $certificate->getClientOriginalName();
            $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
            $data['certificate_file'] = $certificateFile;
            $data['certificate_url'] = $certificateUrl;

            if (!is_null($document->uploaded_file_url) && Storage::disk('public')->exists($document->uploaded_file_url)) {
                Storage::disk('public')->delete($document->uploaded_file_url);
                ContractorDocument::where('id', $docs_id)
                    ->update([
                        'uploaded_file_name' =>  $certificateFile,
                        'uploaded_file_url' => $certificateUrl,
                        'status' => 'PENDING'
                    ]);

                //rest document comment after reupload in rejecteddocs table
                RejectedDocuments::where('document_id', $docs_id)->update([
                    'comments' => '',
                ]);

                $Count_rejected_docs = ContractorDocument::where('user_id', $document->user_id)->where(['status' => 'REJECTED'])->get()->count();

                //  if rejected document is 0 and pending document is 0 then contractor will approve
                if (($Count_rejected_docs == 0)) {
                    Contractor::where('user_id', $document->user_id)->update([
                        'document_status' => 'submitted',
                    ]);
                }
            }
        }
        return redirect()->route('admin.dashboard');
    }

    //Upload expired documents

    public function ReUploadExpiredDocument(SubcontractorDocumentRequest $request, $docs_id)
{
    $docs_id = jsdecode_userdata($docs_id);
    $document = ContractorDocument::where('id', $docs_id)->firstOrFail();
    // @dd($request->all());
    $data = [
        'document_name' => $request->input('document.' . $docs_id . '.admin_document_name'),
    ];
    if ($request->hasFile('document.' . $docs_id . '.certificate')) {
        $certificate = $request->file('document.' . $docs_id . '.certificate');
        $certificateFile = $certificate->getClientOriginalName();
        $certificateUrl = Storage::disk('public')->put('worker/certificate', $certificate);
        $data['uploaded_file_name'] = $certificateFile;
        $data['uploaded_file_url'] = $certificateUrl;
    }

    $data['valid_between'] = $request->admin_dates;
    // @dd($data);

    if (!empty($data['uploaded_file_url']) && Storage::disk('public')->exists($document->uploaded_file_url)) {
        Storage::disk('public')->delete($document->uploaded_file_url);
    }
    // @dd($data);
    $document->update($data);

    return back();
}



    // view for contracto who is under document verification
    public function showdetails($slug)
    {

        $user = User::with('contractor.architect')->where('slug', $slug)->firstOrFail();
        $user_documents = ContractorDocument::where('user_id', $user->id)->where('status', 'PENDING')->get();

        return view('admin.contractor.viewdetails', compact('user', 'user_documents'));
    }

    public function approvedocument($doc_id)
    {
        $authUser = auth::user();
        $GetUserId = ContractorDocument::where('id', $doc_id)->firstOrFail();
        ContractorDocument::where('id', $doc_id)->update(['status' => 'APPROVED']);

        //total document list
        $GetDocsList =  ContractorDocument::where('user_id', $GetUserId->user_id)->count();

        //approved document list
        $GetApproveDocsList = ContractorDocument::where('user_id', $GetUserId->user_id)->where('status', 'APPROVED')->count();

        //condition if  total document is equal to approved document then  approved contractor profile
        if ($GetDocsList ==  $GetApproveDocsList) {
            Contractor::where('user_id', $GetUserId->user_id)->update([
                'document_status' => "approved",
                'is_approved' => '1',
                'approved_by' =>  auth::user()->id,


            ]);
        }
        return redirect()->back();
    }

    public function rejectdocument(RejectDocumentRequest $request, $doc_id)
    {
        $authUser = auth::user();
        $GetUserId = ContractorDocument::where('id', $doc_id)->firstOrFail();
        ContractorDocument::where('id', $doc_id)->update(['status' => 'REJECTED']);
        RejectedDocuments::insert(['document_id' => $doc_id, 'comments' => $request->comment]);
        // total rejected documents
        $GetRejectedDocsList = ContractorDocument::where('user_id', $GetUserId->user_id)->where('status', 'REJECTED')->count();
        //if there is any one document with a rejected status then set contractor profile as rejected
        if ($GetRejectedDocsList != 0) {
            Contractor::where('user_id', $GetUserId->user_id)->update([
                'document_status' => "rejected",
                'is_approved' => '0',
            ]);
        }
        // return  redirect()->route( $authUser->role.'.approve.contractors');
        return redirect()->back();
    }
}
