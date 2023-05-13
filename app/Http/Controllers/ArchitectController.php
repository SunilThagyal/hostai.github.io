<?php

namespace App\Http\Controllers;

use App\Events\WelcomeNotification;
use App\Http\Requests\AddArchitectRequest;
use App\Models\{EmailTemplate, Site, User, UserSite};
use App\Notifications\CommonNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Hash, Storage};

class ArchitectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roleId = config('constants.project-manager');
        $users = User::with('userSites.site','architectContractors')->where('role', $roleId)->when(!is_null($request->search), function($q) use($request) {
            $q->where('first_name', 'like', '%' . $request->search . '%');
        })->orderByDesc('id')->get();

        return view('admin.architect.architects', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userSites = UserSite::groupBy('site_id')->pluck('site_id')->toArray();
        $sites = Site::whereNotIn('id', $userSites)->where('status', 'Active')->get();

        return view('admin.architect.add', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddArchitectRequest $request)
    {
        $projectmanager = config('constants.project-manager');

        DB::beginTransaction();
        try {
            $data = [
                'role' => $projectmanager,
                'first_name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'location' => $request->location,
            ];

            if ($request->has('profile_pic')) {
                $profile = $request->file('profile_pic');
                $profilePicFile = $profile->getClientOriginalName();
                $profilePicUrl = Storage::disk('public')->put('architect/profilePicture', $profile);
                $data['profile_file'] = $profilePicFile;
                $data['profile_url'] =$profilePicUrl;
            }

            $user = User::create($data);

            $constructionSite = [];
            if (!is_null($request->construction_site)) {
                foreach($request->construction_site as $site){
                    $constructionSite[] = [
                        'user_id' => $user->id,
                        'site_id' => $site,
                    ];

                }
            }
            if (count($constructionSite)) {
                UserSite::insert($constructionSite);
            }

            DB::commit();
            $notificationData=[
                'password' => $request->password,
                'email' => $request->email,
                'name' => $request->name,
            ];

            $template = EmailTemplate::where('slug', 'project-manger')->firstOrFail();

            $password = $request->password;
            $email = $request->email;

            if (!is_null($template)) {
                $strReplace = [
                    '[APP_NAME]',
                    '[URL]',
                    '[PASSWORD]',
                    '[EMAIL]',
                    '[URL]',
                ];
                $strReplaceWith = [
                    config('app.name'),
                    route('login'),
                    $password,
                    $email,
                    route('login'),
                ];
                $subject = str_replace($strReplace, $strReplaceWith, $template->subject);
                $content = str_replace($strReplace, $strReplaceWith, $template->content);
                $data = [
                    'subject' => $subject,
                    'content' => $content,
                ];

                $user->notify(new CommonNotification($data));
            }

            return redirect()->route('admin.architects');
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
        $user = User::with('userSites.site')->where('slug', $slug)->firstOrFail();

        return view('admin.architect.view',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user = User::with('userSites.site')->where('slug', $slug)->firstOrFail();
        if(is_null($user)) {

            return redirect()->route('admin.architects')->with(['status' => 'danger', 'message' => 'User Not found']);
        }
        $managerSiteIds = $user->userSites->pluck('site_id')->toArray();
        $userSites = UserSite::when(count($user->userSites), function($q) use($managerSiteIds) {
            $q->whereNotIn('site_id', $managerSiteIds);
        })->groupBy('site_id')->pluck('site_id')->toArray();
        $sites = Site::whereNotIn('id', $userSites)->where('status', 'Active')->get();

        return view('admin.architect.update',compact('user', 'sites', 'managerSiteIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddArchitectRequest $request, $slug)
    {
        $user = User::with('userSites')->where('slug', $slug)->firstOrFail();


        $data = [
            'first_name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
        ];
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->has('profile_pic')) {
            $profile = $request->file('profile_pic');
            $profilePicFile = $profile->getClientOriginalName();
            $profilePicUrl = Storage::disk('public')->put('architect/profilePicture', $profile);
            $data['profile_file'] = $profilePicFile;
            $data['profile_url'] =$profilePicUrl;

            if (!is_null($user->profile_url) && Storage::disk('public')->exists($user->profile_url)) {
                Storage::disk('public')->delete($user->profile_url);
            }
        }
        $user->update($data);

        $constructionSite = [];
        if (!is_null($request->construction_site)) {
            UserSite::where('user_id', $user->id)->delete();
            foreach($request->construction_site as $site) {
                $constructionSite[] = [
                    'user_id' => $user->id,
                    'site_id' => $site,
                ];
            }
        }
        if (count($constructionSite)) {
            UserSite::insert($constructionSite);
        }

        return redirect()->route('admin.architects')->with(['status' => 'success', 'message' => 'Architect update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $manager = User::where('slug', $slug)->firstOrFail();
        $users = [];
        $manager->architectContractors()->delete();
        $manager->architectWorkers()->delete();
        $manager->userSites()->delete();
        $manager->delete();
        // $contractors = $manager->architectContractors->pluck('user_id')->toArray();
        // $workers = $manager->architectWorkers->pluck('user_id')->toArray();

        // if (count($contractors)) {
        //     User::where('id', $contractors)->delete();
        // }

        // foreach ($user_contractors as $contractors){
        //     foreach ($contractors as $getcontra) {
        //         $arch_contractors = User::where('id', $getcontra['user_id']);
        //         $arch_contractors->delete();
        //     }
        // }

        // foreach ($user_workers as $workers) {
        //     foreach ($workers as $getworkers) {
        //         $arch_workers = User::where('id', $getworkers['user_id']);
        //         $arch_workers->delete();
        //     }
        // }

        // $delete_user = User::where('slug', $slug)->first();
        // $delete_user->userSites()->delete();
        // $delete_user->delete();

        return redirect()->route('admin.architects')->with(['status' => 'danger', 'message' => 'Architect deleted successfully']);
    }
}
