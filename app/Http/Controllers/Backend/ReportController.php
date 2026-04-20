<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Backend\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
class ReportController extends Controller
{
    public function dc() { return view('report_dc'); }
    public function dmo() { return view('report_dmo'); }
    public function kprts() { return view('report_kprts'); }
}