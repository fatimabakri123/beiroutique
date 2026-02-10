<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoyaltySetting;

class LoyaltySettingController extends Controller
{
    /**
     * Save or update loyalty settings for a shop.
     */
    public function save(Request $request)
    {
        $shop_id = $request->shop_id;

        // Validate input
        $data = $request->validate([
            'min_orders' => 'required|integer|min:1',
            'min_revenue' => 'required|numeric|min:0',
            'discount_percentage' => 'required|integer|min:1|max:100',
        ]);

        // Update or create loyalty setting
        $loyalty = LoyaltySetting::updateOrCreate(
            ['shop_id' => $shop_id],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => 'Loyalty settings saved successfully!',
            'loyalty' => $loyalty
        ]);
    }
}