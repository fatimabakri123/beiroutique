<?php

// app/Http/Controllers/Admin/AdminNotificationController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\ShopOwner;
use App\Notifications\AdminMessage;
use Illuminate\Support\Facades\Notification;

class AdminNotificationController extends Controller
{
    // Show notifications form
    public function index()
    {
        $notifications = \DB::table('notifications')
            ->where('type', AdminMessage::class)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    // Send notification
    public function send(Request $request)
    {
        $request->validate([
            'target' => 'required',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $notification = new AdminMessage($request->title, $request->message);

        switch ($request->target) {
            case 'all':
                Notification::send(
                    User::all()->merge(Customer::all())->merge(ShopOwner::all()),
                    $notification
                );
                break;

            case 'users':
                Notification::send(User::all(), $notification);
                break;

            case 'customers':
                Notification::send(Customer::all(), $notification);
                break;

            case 'shop_owners':
                Notification::send(ShopOwner::all(), $notification);
                break;

            default:
                // Specific user: format "user:ID", "customer:ID", "shop:ID"
                if (str_contains($request->target, ':')) {
                    [$role, $id] = explode(':', $request->target);
                    $model = match($role) {
                        'user' => User::find($id),
                        'customer' => Customer::find($id),
                        'shop' => ShopOwner::find($id),
                        default => null
                    };
                    if ($model) $model->notify($notification);
                }
        }

        return back()->with('success', 'Notification sent successfully!');
    }

    // Delete a single notification
    public function destroy($id)
    {
        \DB::table('notifications')->where('id', $id)->delete();
        return back()->with('success', 'Notification deleted!');
    }

    // Delete all notifications
    public function destroyAll()
    {
        \DB::table('notifications')->delete();
        return back()->with('success', 'All notifications deleted!');
    }
}
