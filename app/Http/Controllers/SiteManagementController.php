<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteRequest;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sites = Site::with('userSites')
        ->when(!is_null($request->search), function($q) use($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        })->orderByDesc('id')->get();

        return view('admin.site.sites', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.site.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteRequest $request)
    {
        Site::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.sites');

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
    public function edit($slug)
    {
        $site = Site::where('slug', $slug)->first();

        return view('admin.site.update', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $site = Site::where('slug', $slug)->first();

        if($site->name != $request->name){
            $request->validate([
                'name' =>  ['required', 'unique:sites,name','string'],
            ]);


            Site::where('id',$site->id)->update([
                'name'  =>  $request->name,
                'status' => $request->status,
            ]);
        }
        else{
            Site::where('id',$site->id)->update([
                'name'  =>  $request->name,
                'status' => $request->status,
            ]);

        }



        return redirect()->route('admin.sites');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $site = Site::where('slug', $slug)->firstOrFail();

        $site->userSites()->delete();
        $site->delete();

        return redirect()->route('admin.sites');

    }
}
