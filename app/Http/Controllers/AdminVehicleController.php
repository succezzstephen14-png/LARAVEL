<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminVehicleController extends Controller
{
    /**
     * Show all vehicles with filters.
     */
    public function index(Request $request)
    {
        $query = Vehicle::with('user')->latest();

        // Filter by approval status
        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        // Filter by availability
        if ($request->filled('availability_status')) {
            $query->where('availability_status', $request->availability_status);
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $vehicles = $query->paginate(15);
        $approvalStatuses = ['pending', 'approved', 'rejected', 'suspended'];
        $availabilityStatuses = ['available', 'in_use', 'unavailable'];
        $conditions = ['excellent', 'very_good', 'good', 'fair', 'needs_maintenance'];

        return view('admin.vehicles.index', compact('vehicles', 'approvalStatuses', 'availabilityStatuses', 'conditions'));
    }

    /**
     * Show vehicle details.
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load('user');
        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Approve a vehicle.
     */
    public function approve(Vehicle $vehicle)
    {
        if ($vehicle->approval_status === 'approved') {
            return back()->with('info', 'Vehicle is already approved.');
        }

        $previousStatus = $vehicle->approval_status;
        
        $vehicle->update([
            'approval_status' => 'approved',
            'availability_status' => 'available',
        ]);

        $this->notifyModelOwner(
            $vehicle,
            'Vehicle approved',
            'Your vehicle listing has been approved and is now available for booking.'
        );
        $this->sendOwnerDecisionEmail(
            $vehicle,
            'Your vehicle listing has been approved',
            'Your vehicle listing has been approved and is now available for booking.'
        );

        // Log the approval
        AuditLog::log(
            'vehicle_approval',
            "Vehicle {$vehicle->license_plate} approved",
            'Vehicle',
            $vehicle->id,
            ['approval_status' => $previousStatus, 'availability_status' => $vehicle->getOriginal('availability_status')],
            ['approval_status' => 'approved', 'availability_status' => 'available']
        );

        return back()->with('success', 'Vehicle has been approved successfully.');
    }

    /**
     * Reject a vehicle.
     */
    public function reject(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);

        if ($vehicle->approval_status === 'rejected') {
            return back()->with('info', 'Vehicle is already rejected.');
        }

        $previousStatus = $vehicle->approval_status;
        
        $vehicle->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'availability_status' => 'unavailable',
        ]);

        $this->notifyModelOwner(
            $vehicle,
            'Vehicle rejected',
            'Your vehicle listing has been rejected. Reason: ' . $request->rejection_reason
        );
        $this->sendOwnerDecisionEmail(
            $vehicle,
            'Your vehicle listing has been rejected',
            'Your vehicle listing has been rejected. Reason: ' . $request->rejection_reason
        );

        // Log the rejection
        AuditLog::log(
            'vehicle_rejection',
            "Vehicle {$vehicle->license_plate} rejected: {$request->rejection_reason}",
            'Vehicle',
            $vehicle->id,
            ['approval_status' => $previousStatus],
            ['approval_status' => 'rejected', 'rejection_reason' => $request->rejection_reason]
        );

        return back()->with('success', 'Vehicle has been rejected.');
    }

    /**
     * Update vehicle availability (admin only).
     */
    public function updateAvailability(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'availability_status' => 'required|in:available,in_use,unavailable',
        ]);

        $previousStatus = $vehicle->availability_status;
        
        $vehicle->update([
            'availability_status' => $request->availability_status,
        ]);

        // Log the availability change
        AuditLog::log(
            'vehicle_availability_change',
            "Vehicle {$vehicle->license_plate} availability changed from {$previousStatus} to {$request->availability_status}",
            'Vehicle',
            $vehicle->id,
            ['availability_status' => $previousStatus],
            ['availability_status' => $request->availability_status]
        );

        return back()->with('success', 'Vehicle availability has been updated.');
    }

    /**
     * Suspend a vehicle.
     */
    public function suspend(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'suspension_reason' => 'required|string|min:10|max:500',
        ]);

        $previousStatus = $vehicle->availability_status;
        
        $vehicle->update([
            'availability_status' => 'unavailable',
            'suspension_reason' => $request->suspension_reason,
        ]);

        // Log the suspension
        AuditLog::log(
            'vehicle_suspension',
            "Vehicle {$vehicle->license_plate} suspended: {$request->suspension_reason}",
            'Vehicle',
            $vehicle->id,
            ['availability_status' => $previousStatus],
            ['availability_status' => 'unavailable', 'suspension_reason' => $request->suspension_reason]
        );

        return back()->with('success', 'Vehicle has been suspended.');
    }

    /**
     * Resume a suspended vehicle.
     */
    public function resume(Vehicle $vehicle)
    {
        if ($vehicle->availability_status !== 'unavailable') {
            return back()->with('info', 'This vehicle is not suspended.');
        }

        $previousStatus = $vehicle->availability_status;
        
        $vehicle->update([
            'availability_status' => 'available',
            'suspension_reason' => null,
        ]);

        // Log the resume
        AuditLog::log(
            'vehicle_resume',
            "Vehicle {$vehicle->license_plate} resumed",
            'Vehicle',
            $vehicle->id,
            ['availability_status' => $previousStatus, 'suspension_reason' => 'unavailable'],
            ['availability_status' => 'available', 'suspension_reason' => null]
        );

        return back()->with('success', 'Vehicle has been resumed.');
    }
}
