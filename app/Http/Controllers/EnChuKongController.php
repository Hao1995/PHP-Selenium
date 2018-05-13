<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facebook\FacebookSelenium;
use App\Facebook\Test;

class EnChuKongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $domain = 'localhost';
        $starttime = microtime(true);
        $file      = @fsockopen($domain, 4444, $errno, $errstr, 10);
        $stoptime  = microtime(true);
        $status    = false; //App is down

        if ($file) { 
            fclose($file);
            $status = true; //APP is up
        }

        return view('EnChuKong.index', compact('status'));
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

    // Selenium

    public function startSeleniumServer(Request $request){

        $cmd = 'start /min cmd.exe @cmd /k "title SeleniumServer & cd .. & java -jar selenium-server-standalone-3.11.0.jar"';
        $fp= popen($cmd,'r');
        pclose($fp);

        return redirect()->back();
    }

    public function stopSeleniumServer(Request $request){

        $cmdOutput = exec('chcp 65001 & taskkill /IM cmd.exe /fi "WINDOWTITLE eq SeleniumServer*"');
        $splitString = explode(":", $cmdOutput);

        $status = $splitString[0];

        if ($status == 'SUCCESS'){
            return redirect()->back();
        }
        
        $cmdOutput = exec('chcp 65001 & taskkill /IM cmd.exe /fi "WINDOWTITLE eq 選取 SeleniumServer*"');
        $splitString = explode(":", $cmdOutput);

        $status = $splitString[0];

        if ($status == 'SUCCESS'){
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function webdriver(Request $request){

        $haoWebdriver = new FacebookSelenium();
        return $haoWebdriver->index();
    }
}
