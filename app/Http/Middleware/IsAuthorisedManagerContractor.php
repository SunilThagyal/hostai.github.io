<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Closure;

class IsAuthorisedManagerContractor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $slug = $request->route()->parameters()['slug'];

        if (is_null($slug)) {
            return redirect()->route($user->role.'.dashboard')->with(['status' => 'info', 'message' => 'Something wrong with the url']);
        }

        $worker = User::with('Worker')->where('slug', $slug)->first();

        if (is_null($worker)) {
            return redirect()->route($user->role.'.dashboard')->with(['status' => 'info', 'message' => 'Worker doesn\'t exist now']);
        }

        $admin = config('constants.admin');
        $manager = config('constants.manager');
        $subContractor = config('constants.subcontractor');
        $projectmanager = config('constants.project-manager');
        if ($admin == $user->role) {
            return $next($request);
        } elseif ($manager == $user->role && !in_array($user->id, $worker->Worker->subManagerIds)) {
            return redirect()->route($user->role.'.dashboard')->with(['status' => 'info', 'message' => 'You are not authorised to view']);
        } elseif ($subContractor == $user->role && $user->id != $worker->Worker->contractor_id) {
            return redirect()->route($user->role.'.dashboard')->with(['status' => 'info', 'message' => 'You are not authorised to view']);
        } elseif ($projectmanager == $user->role && $user->id != $worker->Worker->manager_id) {
            return redirect()->route($user->role.'.dashboard')->with(['status' => 'info', 'message' => 'You are not authorised to view']);
        } elseif (!in_array($user->role, [$admin, $manager, $projectmanager, $subContractor])) {
            return redirect(url('/'))->with(['status' => 'info', 'message' => 'You are not authorised to view']);
        }

        return $next($request);
    }
}
