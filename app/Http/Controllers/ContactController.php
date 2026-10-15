<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Validate contact form
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        // Save message first
        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        // Clinic notification email
        $clinicEmail = config('mail.contact_recipient');

        if (filter_var($clinicEmail, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($clinicEmail)->queue(
                    new ContactMessageReceived($contactMessage)
                );
            } catch (\Throwable $exception) {
                // Message remains saved even if email queueing fails
                Log::error('Medicare+ contact email queue failed', [
                    'contact_message_id' => $contactMessage->id,
                    'error' => $exception->getMessage(),
                ]);
            }
        } else {
            Log::warning('Medicare+ contact recipient not configured', [
                'contact_message_id' => $contactMessage->id,
            ]);
        }

        return redirect()
            ->route('contact')
            ->with(
                'success',
                'Your message has been received successfully. Our team will get back to you soon.'
            );
    }
}
