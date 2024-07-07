<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('show.dashboard', absolute: false));
        }

        try {
            // Send the email
            $request->user()->SendEmailVerificationNotification();
        } catch (\Exception $e) {
            // Log the error message or take any action you need
            Log::error('Failed to send email: ' . $e->getMessage());

            // You can also set a flash message or some indication for the user
            session()->flash('error', 'Gagal mengirim email, silahkan coba lagi nanti.');
        }

        return back()->with([
            'status', 'verification-link-sent',
        ]);
    }
}
