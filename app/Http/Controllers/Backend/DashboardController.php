<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function main()
    {
        return view('dashboard');
    }

    public function dc()
    {
        return view('dashboard_dc');
    }

    public function dmo()
    {
        return view('dashboard_dmo');
    }

    public function rtcp()
    {
        return view('dashboard_rtcp');
    }

     public function report_dc()
    {
        return view('report_dc');
    }

     public function report_dmo()
    {
        return view('report_dmo');
    }

    public function fazalManan()
    {
        return view('dashboard_fazal_manan');
    }

    public function armsLicence()
    {
        return view('dashboard_arms_licence');
    }

    public function armsLicenceDetail()
    {
        return view('dashboard_arms_licence_detail');
    }

    public function armsLicenceForward()
    {
        return view('dashboard_arms_licence_forward');
    }

    public function kprts()
    {
        return view('report_kprts');
    }
}