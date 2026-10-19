<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    /**
     * Export Bookings
     */
    public function exportBookings(Request $request)
    {
        $format = $request->get('format', 'csv');
        $bookings = Booking::with('user', 'recruitment')->orderBy('created_at', 'desc')->get();

        $data = $bookings->map(function ($booking) {
            return [
                'ID' => $booking->id,
                'Guest Name' => $booking->guest_name,
                'Guest Email' => $booking->guest_email,
                'User' => $booking->user?->name ?? 'N/A',
                'Position' => $booking->recruitment?->position_type ?? 'N/A',
                'Status' => $booking->status,
                'Tracking Status' => $booking->tracking_status,
                'Amount' => $booking->amount,
                'Payment Status' => $booking->payment_status,
                'Created' => $booking->created_at?->format('Y-m-d H:i:s'),
                'Updated' => $booking->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        return $this->formatExport($data, 'bookings', $format);
    }

    /**
     * Export Drivers
     */
    public function exportDrivers(Request $request)
    {
        $format = $request->get('format', 'csv');
        $drivers = Driver::with('user')->orderBy('created_at', 'desc')->get();

        $data = $drivers->map(function ($driver) {
            return [
                'ID' => $driver->id,
                'Name' => $driver->user?->name ?? 'N/A',
                'Email' => $driver->user?->email ?? 'N/A',
                'License Number' => $driver->license_number,
                'License Expiry' => $driver->license_expiry,
                'Phone' => $driver->user?->phone ?? 'N/A',
                'Status' => $driver->status,
                'Approval Status' => $driver->approval_status,
                'Years Experience' => $driver->years_of_experience,
                'Created' => $driver->created_at?->format('Y-m-d H:i:s'),
                'Updated' => $driver->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        return $this->formatExport($data, 'drivers', $format);
    }

    /**
     * Export Users
     */
    public function exportUsers(Request $request)
    {
        $format = $request->get('format', 'csv');
        $users = User::orderBy('created_at', 'desc')->get();

        $data = $users->map(function ($user) {
            return [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Phone' => $user->phone ?? 'N/A',
                'Role' => $user->role,
                'Status' => $user->status ?? 'active',
                'Onboarding Completed' => $user->onboarding_completed ? 'Yes' : 'No',
                'Email Verified' => $user->email_verified_at ? 'Yes' : 'No',
                'Created' => $user->created_at?->format('Y-m-d H:i:s'),
                'Last Login' => $user->last_login_at?->format('Y-m-d H:i:s') ?? 'Never',
            ];
        });

        return $this->formatExport($data, 'users', $format);
    }

    /**
     * Export bulk users
     */
    public function bulkExportUsers(Request $request)
    {
        $format = $request->get('format', 'csv');
        $userIds = explode(',', $request->get('user_ids', ''));
        $userIds = array_filter(array_map('intval', $userIds));

        if (empty($userIds)) {
            return back()->with('error', 'No users selected');
        }

        $users = User::whereIn('id', $userIds)->get();

        $data = $users->map(function ($user) {
            return [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Phone' => $user->phone ?? 'N/A',
                'Role' => $user->role,
                'Status' => $user->status ?? 'active',
                'Onboarding Completed' => $user->onboarding_completed ? 'Yes' : 'No',
                'Email Verified' => $user->email_verified_at ? 'Yes' : 'No',
                'Created' => $user->created_at?->format('Y-m-d H:i:s'),
                'Last Login' => $user->last_login_at?->format('Y-m-d H:i:s') ?? 'Never',
            ];
        });

        return $this->formatExport($data, 'users_bulk', $format);
    }

    /**
     * Format and return export data
     */
    private function formatExport($data, $filename, $format)
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "{$filename}_{$timestamp}";

        switch ($format) {
            case 'json':
                return Response::json($data, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
                    ->header('Content-Disposition', "attachment; filename=\"{$filename}.json\"");

            case 'excel':
                return $this->exportToExcel($data, $filename);

            case 'pdf':
                return $this->exportToPDF($data, $filename);

            case 'csv':
            default:
                return $this->exportToCSV($data, $filename);
        }
    }

    /**
     * Export to CSV format
     */
    private function exportToCSV($data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Write BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write header row
            if ($data->count() > 0) {
                fputcsv($file, array_keys($data->first()));
            }

            // Write data rows
            foreach ($data as $row) {
                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export to Excel format (using CSV variant for simplicity)
     */
    private function exportToExcel($data, $filename)
    {
        // For now, Excel format will be identical to CSV
        // In a production environment, you'd use Laravel Excel package
        return $this->exportToCSV($data, str_replace('.csv', '.xlsx', $filename));
    }

    /**
     * Export to PDF format
     */
    private function exportToPDF($data, $filename)
    {
        // Generate HTML table for PDF
        $html = '<html><body><table border="1" cellpadding="5">';

        if ($data->count() > 0) {
            $html .= '<tr>';
            foreach (array_keys($data->first()) as $header) {
                $html .= '<th>' . htmlspecialchars($header) . '</th>';
            }
            $html .= '</tr>';
        }

        foreach ($data as $row) {
            $html .= '<tr>';
            foreach (array_values($row) as $value) {
                $html .= '<td>' . htmlspecialchars($value) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table></body></html>';

        // Return as PDF (basic implementation using wkhtmltopdf or similar)
        // For now, return as downloadable HTML that can be printed as PDF
        return Response::make($html, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}.pdf\"",
        ]);
    }
}
