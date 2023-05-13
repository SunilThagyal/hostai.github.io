<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use QrCode;

class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function qrCode(Request $request,$slug)
    {

        $worker = User::with('userSites.site','Worker.workerContractor','Worker.architect')->where('slug', $request->slug)->first();
        $url = url('worker/'.$slug.'/show');

        return view('qrcode',compact('url','worker'));
    }

    public function qrCodePrint(Request $request,$slug)
    {

        $user = User::with('userSites.site','Worker.workerContractor','Worker.architect')->where('slug', $request->slug)->first();
        $url = url('worker/'.$slug.'/show');
        $customPaper = array(0,0,213.4,213.4);
        // return view('qrprint',compact('url','user'));
        $pdf = Pdf::loadView('qrprint',compact('url','user'))->setPaper($customPaper, 'landscape');
        // $pdf->setOptions(['dpi' => 203 ]);
        return $pdf->stream();


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
