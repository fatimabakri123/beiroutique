<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller {
    public function index(){
        $settings = [
            'currency' => config('settings.currency') ?? 'USD'
        ];
        return view('admin.settings.index', compact('settings'));
    }
    public function save(Request $r){
        // store settings in DB or config table. Minimal example:
        // Setting::set('currency', $r->currency);
        return redirect()->back()->with('success','Saved');
    }
}
