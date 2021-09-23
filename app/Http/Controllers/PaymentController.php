<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\SiteHelper;
use DB;
use App\User;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();

    }

    /**
     * transakFramePayment
     */
    public function index()
    {
        return view('account.transak_iframe');
    }

    /**
     * Transak Payment
     */
    public function transakPayment()
    {
        return view('account.transak');
    }

    /**
     * Transak Success
     */
    public function transakSuccess(Request $request)
    {
        dd($request);
    }
}
