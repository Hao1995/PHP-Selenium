<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        // $cmd = 'start cmd.exe @cmd /k "ping google.com"';
        // $cmd = 'start cmd.exe @cmd /k "cd .. & java -jar selenium-server-standalone-3.11.0.jar"';

        //php_uname() >> Windows NT LAPTOP-GJE59E32 10.0 build 16299 (Windows 10) i586
        
        // if (substr(php_uname(), 0, 7) == "Windows"){ 
        // return "Exec First";
        //     pclose(popen("start /B ". $cmd, "r"));  
        // } 
        // else { 
            // exec($cmd . " > /dev/null &");   
        //     return "This device is not Windows";
        // } 

        
        // exec($cmd);
        // exec('start cmd.exe @cmd /k "cd .. & php MultipleThread.php"');
        // exec('startSeleniumServer.bat');
        // exec('start cmd.exe @cmd /k "cd .. & startSeleniumServer.bat"');
        // exec('start /min cmd.exe @cmd /k "cd .. & startSeleniumServer.bat"');
        // $data = exec('java -jar selenium-server-standalone-3.11.0.jar');

        $fp= popen('start /min cmd.exe @cmd /k "title SeleniumServer & cd .. & java -jar selenium-server-standalone-3.11.0.jar"','r');
        pclose($fp);

        //Next ===> Already start selenium server. We have to checkt the status of port 4444
        // return view('EnChuKong.index', compact('status'));
        return redirect()->back();
    }
}
