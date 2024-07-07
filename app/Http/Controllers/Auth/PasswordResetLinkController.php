<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
            'error' => session('error'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            // Send the email
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
                return back()->with('status', __($status));
            }

            throw ValidationException::withMessages([
                'email' => [trans($status)],
            ]);
        } catch (TransportExceptionInterface $e) {
            // Log the error message
            Log::error('Failed to send email: ' . $e->getMessage());

            // Set a flash message for the user
            return back()->with('error', 'Gagal mengirim email, silahkan coba lagi nanti.');
        } catch (\Exception $e) {
            // Log any other exceptions
            Log::error('An error occurred: ' . $e->getMessage());

            // Set a flash message for the user
            return back()->with('error', 'Terjadi kesalahan, silahkan coba lagi nanti.');
        }
    }
}
