<?php

namespace App\Http\Controllers;

use App\Models\{Contractor, ContractorDocument, EmailTemplate, Manager, User, Worker};
use App\Notifications\CommonNotification;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Storage};

class ManagerController extends Controller
{
    public function index(Request $request , $type)
    {
        $managers = Manager::with('user')
        ->whereHas('user',function( $query ) use($type) {
            $query->where('role',$type);
        })
        ->where('project_manager_id', auth()->user()->id)
        ->when(!is_null($request->search), function($q) use($request) {
            $q->whereHas('user', function($query) use($request) {
                $query->where('first_name', 'like', '%' . $request->search . '%');
            });
        })->orderByDesc('user_id')->get();

        return view('managers.index', compact('managers'));
    }

    public function create( $type )
    {
        return view('managers.create');
    }

    public function store(Request $request, $type)
    {
        // dd('hello');
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|same:confirm_password|min:6|max:32',
            ], [
                'name.required' => 'Please enter the name',
                'email.required' => 'Please enter the email',
                'email.email' => 'This is not a valid email address',
                'email.unique' => 'This email is already taken',
                'password.same' => 'Password doesn\'t match with confirm password',
                'password.required' => 'Please enter the password',
                'password.min' => 'Password can be vary between 6 to 32 characters long',
                'password.max' => 'Password can be vary between 6 to 32 characters long',
            ]);
            $manager = config('constants.manager');
            $authUser = Auth::user();
            $authUser->load(['architectWorkers']);
            $data = [
                'role' => $type,
                'first_name' => $request->name,
                'last_name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'Active',
            ];

            if ($request->has('profile_pic')) {
                $profile = $request->file('profile_pic');
                $profilePicFile = $profile->getClientOriginalName();
                $profilePicUrl = Storage::disk('public')->put('manager/profilePicture', $profile);
                $data['profile_file'] = $profilePicFile;
                $data['profile_url'] = $profilePicUrl;
            }
            DB::beginTransaction();
            $user = User::create($data);

            Manager::create([
                'user_id' => $user->id,
                'project_manager_id' => $authUser->id,
                'created_by' => $authUser->id
            ]);

            foreach ($authUser->architectWorkers as $worker) {
                $subManagerIds = $worker->sub_manager_ids;
                array_push($subManagerIds, $user->id);
                $where = [
                    ['user_id', '=', $worker->user_id],
                    ['manager_id', '=', $authUser->id],
                ];
                $subManagerIds = array_unique($subManagerIds);
                Worker::where($where)->update([
                    'sub_manager_ids' => implode(',', $subManagerIds)
                ]);
            }

            $template = EmailTemplate::where('slug', 'manager')->first();
            $password = $request->password;
            $email = $request->email;

            if (!is_null($template)) {
                $strReplace = [
                    '[APP_NAME]',
                    '[URL]',
                    '[PASSWORD]',
                    '[EMAIL]',
                ];
                $strReplaceWith = [
                    config('app.name'),
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

            return redirect()->route('project-manager.managers.index',['type'=>$type])->with(['status' => 'success', 'message' => 'Manager has been added successfully']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    public function view($type , $slug)
    {
        $manager = User::where('slug', $slug)->firstOrFail();
        $userManager = Manager::where('user_id', $manager->id)->first();
        if (is_null($userManager) || $userManager->project_manager_id != auth()->user()->id) {
            return redirect()->route('project-manager.managers.index')->with(['status' => 'danger', 'message' => 'You are not a authorized user']);
        }

        return view('managers.view', compact('manager'));
    }

    public function edit($type , $slug)
    {
        $manager = User::where('slug', $slug)->firstOrFail();
        $userManager = Manager::where('user_id', $manager->id)->first();
        if (is_null($userManager) || $userManager->project_manager_id != auth()->user()->id) {
            return redirect()->route('project-manager.managers.index')->with(['status' => 'danger', 'message' => 'You are not a authorized user']);
        }

        return view('managers.edit', compact('manager'));
    }

    public function update(Request $request, $type , $slug)
    {
        try {
            $user = User::where('slug', $slug)->first();
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

            $authUser = Auth::user();
            $manager = Manager::where('user_id', $user->id)->first();
            if (is_null($manager) || $manager->project_manager_id != $authUser->id) {
                return redirect()->route('project-manager.managers.index')->with(['status' => 'danger', 'message' => 'You are not a authorized user']);
            }

            $data = [
                'first_name' => $request->name,
                'last_name' => $request->name,
                'email' => $request->email,
            ];

            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->has('profile_pic')) {
                $profile = $request->file('profile_pic');
                $profilePicFile = $profile->getClientOriginalName();
                $profilePicUrl = Storage::disk('public')->put('manager/profilePicture', $profile);
                $data['profile_file'] = $profilePicFile;
                $data['profile_url'] = $profilePicUrl;

                if (!is_null($user->profile_url) && Storage::disk('public')->exists($user->profile_url)) {
                    Storage::disk('public')->delete($user->profile_url);
                }
            }
            $user->update($data);

            return redirect()->route('project-manager.managers.index',['type'=>$type])->with(['status' => 'success', 'message' => 'Manager has been updated successfully']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function destroy( $type , $slug)
    {
        $manager = User::where('slug', $slug)->firstOrFail();
        $userManager = Manager::where('user_id', $manager->id)->first();
        $authUser = Auth::user();
        $authUser->load(['architectWorkers']);
        if (is_null($userManager) || $userManager->project_manager_id != $authUser->id) {
            return redirect()->route('project-manager.managers.index')->with(['status' => 'danger', 'message' => 'You are not a authorized user']);
        }
        DB::beginTransaction();
        foreach ($authUser->architectWorkers as $worker) {
            $subManagerIds = $worker->sub_manager_ids;
            $index = array_search($manager->id, $subManagerIds);
            unset($subManagerIds[$index]);
            $where = [
                ['user_id', '=', $worker->user_id],
                ['manager_id', '=', $authUser->id],
            ];
            $subManagerIds = array_unique($subManagerIds);
            Worker::where($where)->update([
                'sub_manager_ids' => implode(',', $subManagerIds)
            ]);
        }
        $manager->delete();
        DB::commit();

        return redirect()->route('project-manager.managers.index',['type'=>$type])->with(['status' => 'success', 'message' => 'Manager has been deleted successfully']);
    }


    public function dashboard(Request $request)
    {
        $authUser = Auth::user();
        $projectManagerId = Manager::where('user_id', $authUser->id)->pluck('project_manager_id')->first();
        $contractors = Contractor::where('manager_id', $projectManagerId)->count();
        $workers = Worker::where('manager_id', $projectManagerId)->count();

        return view('managers.dashboard', compact('contractors', 'workers'));
    }

    public function contractors(Request $request)
    {
        $authUser = Auth::user();
        $projectManagerId = Manager::where('user_id', $authUser->id)->pluck('project_manager_id')->first();
        $contractors = Contractor::with('user')->where('manager_id', $projectManagerId)
        ->when(!is_null($request->search), function($q) use($request) {
            $q->whereHas('user', function($query) use($request) {
                $query->where('first_name', 'like', '%' . $request->search . '%');
            });
        })->orderByDesc('user_id')->get();

        return view('managers.contractors', compact('contractors'));
    }

    public function workers(Request $request)
    {
        $authUser = Auth::user();
        $projectManagerId = Manager::where('user_id', $authUser->id)->pluck('project_manager_id')->first();
        $workers = Worker::with('user')->where('manager_id', $projectManagerId)
        ->when(!is_null($request->search), function($q) use($request) {
            $q->whereHas('user', function($query) use($request) {
                $query->where('first_name', 'like', '%' . $request->search . '%');
            });
        })->orderByDesc('user_id')->get();

        return view('managers.workers', compact('workers'));
    }

    public function viewContractor($slug)
    {
        try {
            $authUser = Auth::user();
            $projectManagerId = Manager::where('user_id', $authUser->id)->pluck('project_manager_id')->firstOrFail();
            $user = User::with('userSites.site', 'contractor.architect')->where('slug', $slug)->firstOrFail();
            $contractor = Contractor::where('user_id', $user->id)->where('manager_id', $projectManagerId)->firstOrFail();
            $documents = ContractorDocument::where('user_id', $user->id)->get();

            return view('managers.view_contractor', compact('user', 'documents'));
        } catch (\Throwable $th) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $th->getMessage()]);
        }
    }

    public function viewWorker($slug)
    {
        try {
            $authUser = Auth::user();
            $projectManagerId = Manager::where('user_id', $authUser->id)->pluck('project_manager_id')->firstOrFail();
            $user = User::with('userSites.site', 'userDocuments','Worker.workerContractor','Worker.architect')->where('slug', $slug)->firstOrFail();
            $worker = Worker::where('user_id', $user->id)->where('manager_id', $projectManagerId)->firstOrFail();
            $url = url('worker/'.$slug.'/show');

            return view('managers.view_worker', compact('user', 'url'));
        } catch (\Throwable $th) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $th->getMessage()]);
        }
    }

    public function profile()
    {
        return view('managers.profile');
    }

    public function editProfile()
    {
        return view('managers.edit_profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ], [
            'name.required' => 'Please enter the name',
            'email.required' => 'Please enter the email',
            'email.email' => 'This is not a valid email address',
            'email.unique' => 'This email is already taken',
        ]);

        $data = [
            'first_name' => $request->name,
            'last_name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->has('profile_pic')) {
            $profile = $request->file('profile_pic');
            $profilePicFile = $profile->getClientOriginalName();
            $profilePicUrl = Storage::disk('public')->put('manager/profilePicture', $profile);
            $data['profile_file'] = $profilePicFile;
            $data['profile_url'] = $profilePicUrl;

            if (!is_null($user->profile_url) && Storage::disk('public')->exists($user->profile_url)) {
                Storage::disk('public')->delete($user->profile_url);
            }
        }
        $user->update($data);

        return redirect()->route('manager.dashboard')->with(['status' => 'success', 'message' => 'Profile has been updated successfully']);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if ('POST' == $request->method()) {
            Auth::user()->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('manager.dashboard')->with(['status' => 'success', 'message' => 'Password has been updated successfully']);
        }

        return view('managers.change_password');
    }

}
