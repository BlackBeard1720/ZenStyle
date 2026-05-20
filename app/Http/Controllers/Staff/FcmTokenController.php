<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FcmToken;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'device_type' => ['nullable', 'string', 'max:50'],
        ]);

        FcmToken::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'token' => $data['token'],
            ],
            [
                'device_type' => $data['device_type'] ?? 'web',
                'last_used_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'FCM token saved successfully.',
        ]);
    }
}
