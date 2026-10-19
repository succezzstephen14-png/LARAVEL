<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Notification;
use App\Models\Recruitment;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function resolveGuestUser(array $contact)
    {
        $email = trim($contact['guest_email'] ?? '');

        if (!$email) {
            return null;
        }

        return User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $contact['guest_name'] ?? 'Guest',
                'phone' => $contact['guest_phone'] ?? null,
                'role' => 'user',
                'password' => Hash::make(Str::random(24)),
            ]
        );
    }

    protected function notifyModelOwner($model, string $title, string $message): void
    {
        $user = null;

        if ($model instanceof Driver || $model instanceof Vehicle || $model instanceof Recruitment) {
            $user = $model->user;
        }

        if ($model instanceof Booking) {
            $user = $model->user;
        }

        if (!$user) {
            return;
        }

        Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => 'system',
            'status' => 'unread',
        ]);
    }

    protected function sendOwnerDecisionEmail($model, string $subject, string $message): void
    {
        $recipientEmail = null;
        $recipientName = 'User';

        if ($model instanceof Booking) {
            $recipientEmail = $model->guest_email ?? $model->user?->email;
            $recipientName = $model->guest_name ?? $model->user?->name ?? 'Guest';
        } elseif ($model instanceof Driver || $model instanceof Vehicle || $model instanceof Recruitment) {
            $recipientEmail = $model->user?->email;
            $recipientName = $model->user?->name ?? 'User';
        }

        if (!$recipientEmail) {
            return;
        }

        $fullMessage = "Hello {$recipientName},\n\n" . $message;

        try {
            Mail::raw($fullMessage, function ($mail) use ($recipientEmail, $subject) {
                $mail->to($recipientEmail)
                    ->subject($subject);
            });
        } catch (\Throwable $e) {
            \Log::error('Failed to send owner decision email', [
                'email' => $recipientEmail,
                'subject' => $subject,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function notifyAdmins(string $subject, string $body): void
    {
        $admins = User::where('role', 'admin')
            ->orWhere('email', 'admin@example.com')
            ->get();

        foreach ($admins as $admin) {
            try {
                Mail::raw($body, function ($message) use ($admin, $subject) {
                    $message->to($admin->email)
                        ->subject($subject);
                });
            } catch (\Throwable $e) {
                \Log::error('Failed to send admin notification email', [
                    'admin_email' => $admin->email,
                    'subject' => $subject,
                    'error' => $e->getMessage(),
                ]);
            }

            Notification::create([
                'user_id' => $admin->id,
                'title' => $subject,
                'message' => $body,
                'type' => 'admin_alert',
            ]);
        }
    }
}
