<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AdminPaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::orderBy('created_at')->get();
        return view('admin.payment_methods.index', compact('methods'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'method_name' => 'required|string|max:100|unique:payment_methods,method_name'
        ]);

        PaymentMethod::create([
            'method_name' => $r->method_name,
            'is_active' => true
        ]);

        return back()->with('success', 'Payment method added successfully.');
    }

    public function toggle($id)
    {
        $method = PaymentMethod::findOrFail($id);

        if ($method->method_name === 'Cash on Delivery') {
            return back()->with('error', 'Cash on Delivery cannot be disabled.');
        }

        $method->update([
            'is_active' => !$method->is_active
        ]);

        return back()->with('success', 'Payment method updated.');
    }
}
