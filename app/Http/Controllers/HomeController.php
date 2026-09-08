<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;


class HomeController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {


    }

        public function index()
    {
       return redirect(route('dashboard'));
    }

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function myTestAddToLog()

    {

        \LogActivity::addToLog('My Testing Add To Log.');

        dd('log insert successfully.');

    }


    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */



}