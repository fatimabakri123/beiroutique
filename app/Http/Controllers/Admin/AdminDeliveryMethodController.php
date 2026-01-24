<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DeliveryMethod;
use Illuminate\Http\Request;

class AdminDeliveryMethodController extends Controller {
    public function index(){
        $methods = DeliveryMethod::all();
        return view('admin.delivery_methods.index', compact('methods'));
    }
    public function store(Request $r){
        $r->validate(['method_name'=>'required','cost'=>'required']);
        DeliveryMethod::create($r->only(['method_name','cost','estimated_time']) + ['is_active'=>true]);
        return redirect()->back();
    }
    public function toggle($id){
        $m = DeliveryMethod::findOrFail($id);
        $m->is_active = !$m->is_active; $m->save();
        return redirect()->back();
    }
}
