<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller {
    public function index(){
        $reports = Report::latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }
    public function show(Report $report){
        return view('admin.reports.show', compact('report'));
    }
    public function resolve(Request $r, Report $report){
        $r->validate(['status'=>'required|string']);
        $report->status = $r->status;
        $report->save();
        // optionally: notify reporter/shop/etc
        return redirect()->back()->with('success','Updated');
    }
}
