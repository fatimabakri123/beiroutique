<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Customer;
use App\Notifications\AdminMessage;

class AdminNotificationController extends Controller
{
    /**
     * Show notifications form (Admin notifications only)
     */
    public function index()
    {
        // جلب آخر 50 إشعار Admin فقط
        $notifications = DB::table('notifications')
            ->where('type', 'App\Notifications\AdminMessage')
            ->select('id', 'data', 'created_at')
            ->latest()
            ->take(50)
            ->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Send notification
     */
    public function send(Request $request)
    {
        $request->validate([
            'target' => 'required',
            'title' => 'required',
            'message' => 'required',
        ]);

        $notification = new AdminMessage(
            $request->title,
            $request->message
        );

        switch ($request->target) {
            case 'all':
                Notification::send(User::all()->merge(Customer::all()), $notification);
                break;

            case 'customers':
                Notification::send(Customer::all(), $notification);
                break;

            case 'shop_owners':
                Notification::send(User::where('role', 'shop_owner')->get(), $notification);
                break;

            default:
                if (str_starts_with($request->target, 'user:')) {
                    $id = explode(':', $request->target)[1];
                    $user = User::find($id);
                    if ($user) $user->notify($notification);
                }
        }

        return back()->with('success', 'Notification sent successfully');
    }

    /**
     * Delete a single Admin notification
     */
    public function destroy($id)
    {
        $notification = DB::table('notifications')->where('id', $id)->first();

        if ($notification && $notification->type === 'App\Notifications\AdminMessage') {
            DB::table('notifications')->where('id', $id)->delete();
            return back()->with('success', 'Notification deleted');
        }

        return back()->with('error', 'You can only delete admin notifications');
    }

    /**
     * Delete all Admin notifications
     */
    public function destroyAll()
    {
        DB::table('notifications')
            ->where('type', 'App\Notifications\AdminMessage')
            ->delete();

        return back()->with('success', 'All Admin notifications deleted');
    }
}
