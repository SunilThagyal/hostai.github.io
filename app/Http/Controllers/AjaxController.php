<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Site;
use App\Models\UserSite;

class AjaxController extends Controller
{
    public function toggleStatus(Request $request)
    {
        try {
            switch ($request->model) {
                case 'User':
                    $class = User::class;
                    break;
                case 'Site':
                    $class = Site::class;
                    break;
                default:
                    $class = "";
            }

            if (empty($class)) {
                return response()->json(['status' => 'error', 'message' => ucwords($request->model) . ' not found'], 404);
            }
            $result = $class::where('slug', $request->slug)->first();

            $status = ($result->status == 'Active') ? 'Inactive': 'Active';

            if ($result->update(['status' => $status])) {
                if ($status == 'Active') {
                    return response()->json(['status' => 'success', 'message' => ucwords($request->model) . ' has been active successfully'], 200);
                } else {
                    return response()->json(['status' => 'danger', 'message' => ucwords($request->model) . ' has been inactive successfully'], 200);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => ucwords($request->model) . ' has not been updated.'], 400);
            }
        } catch (Exception $e) {
            // dd($e);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function architectContractor(Request $request)
     {

         try {
            $user = User::with('contractor')->where('slug', $request->slug)->first();
            $get_contractor = Contractor::with('user')->where(['manager_id' => $user->id, 'is_approved' => '1',])->get();

            $contractors = [];

            foreach($get_contractor as $contractor){
               $contractors[] = [
                   'id' => $contractor->user->id,
                   'role' => $contractor->user->role,
                   'slug' => $contractor->user->slug,
                   'first_name' => $contractor->user->first_name,

               ];
            }
            // @dd($contractors);

             return response()->json([
                 'status' => true,
                 'message' => 'Contractors retrieved successfully',
                 'data' => [
                     'contractors' => $contractors
                 ]
             ]);
         } catch (\Throwable $th) {
             return response()->json([
                 'status' => false,
                 'message' => $th->getMessage(),
                 'errors' => []
             ], 401);
         }
     }

    public function getSite(Request $request)
    {
        try {
            $user = User::select('id')->with('userSites.site:id,name,slug')->where('slug',$request->slug)->first();
            $main_contractors = Contractor::with('user')->where('is_approved','1')->where('manager_id',$user->id)->whereNull('contractor_id')->get()->pluck('user');

            $sites = collect();
            if (count($user->userSites)) {
                $sites = $user->userSites->map(function ($item) {
                    return $item->site;
                });
            }

            return response()->json([
                'status' => true,
                'message' => 'data retrieved successfully',
                'data' => [
                    'sites' => $sites,
                    'contractors' => $main_contractors,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'errors' => []
            ], 401);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
