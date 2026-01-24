<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\orders as Order;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;


class AdminCustomerController extends Controller {
  public function index(Request $request)
{
    $shopId = $request->shop_id;

    $customers = Customer::with(['user','orders.items.product.shop'])
        ->withCount('orders')
        ->when($shopId, function ($q) use ($shopId) {
            $q->whereHas('orders.items.product', function ($qq) use ($shopId) {
                $qq->where('shop_id', $shopId);
            });
        })
        ->paginate(10)
        ->withQueryString();

    $shops = Shop::orderBy('shop_name')->get();

    return view('admin.customers.index', compact('customers','shops','shopId'));
}



   public function show($id)
{
    
    $customer = Customer::find($id);

    if (!$customer) {
        return redirect()->route('admin.customers.index')->with('error', 'Customer not found');
    }

    
    $orders = $customer->orders;

    return view('admin.customers.show', compact('customer', 'orders'));
}

   // AdminCustomerController
public function destroy($customer_id)
{
    $customer = Customer::findOrFail($customer_id);
    $customer->delete();
    return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
}

   public function toggleStatus($customer_id)
{
    $customer = Customer::find($customer_id);
    if ($customer) {
        $customer->status = !$customer->status;
        $customer->save();
    }
    return redirect()->back()->with('success', 'Customer status updated.');
}


public function export(Request $request)
{
    dd('Export called', $request->all());
    return Excel::download(new CustomersExport($request->shop_id), 'customers.xlsx');
}



}