<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'tracking_location' => 'nullable|string|max:255',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($user->driver) {
            $driver = $user->driver;
            $driver->latitude = $validated['latitude'];
            $driver->longitude = $validated['longitude'];
            if (isset($validated['tracking_location'])) {
                $driver->tracking_location = $validated['tracking_location'];
            }
            $driver->last_location_update = now();
            $driver->save();
        } else {
            $user->latitude = $validated['latitude'];
            $user->longitude = $validated['longitude'];
            if (isset($validated['tracking_location'])) {
                $user->tracking_location = $validated['tracking_location'];
            }
            $user->last_location_update = now();
            $user->save();
        }

        return response()->json(['message' => 'Location updated']);
    }
}
