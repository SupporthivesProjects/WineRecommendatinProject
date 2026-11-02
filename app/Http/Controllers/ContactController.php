<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use App\Mail\ContactAcknowledgment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    protected $maxAttempts = 3;
    protected $decayMinutes = 1440; // 24 hours

    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $ip = $request->ip();
        $key = 'contact-form:' . $ip;

        // 🚫 Rate limit check
        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'message' => "Too many attempts. Try again in " . ceil($seconds / 60) . " minutes."
            ])->withInput();
        }

        // ✅ Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'terms' => 'accepted',
            'h-captcha-response' => 'required',
        ]);

        // 🔐 Verify hCaptcha
        $captcha = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret' => config('services.hcaptcha.secret'),
            'response' => $request->input('h-captcha-response'),
            'remoteip' => $ip,
        ]);

        if (!($captcha->json()['success'] ?? false)) {
            RateLimiter::hit($key, $this->decayMinutes * 60); // count failed attempt

            return back()
                ->withErrors(['h-captcha-response' => 'Captcha verification failed.'])
                ->withInput();
        }

        try {
            $contact = ContactRequest::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'terms_accepted' => true,
                'ip_address' => $ip,
            ]);

            // 📧 Send email
            Mail::to($contact->email)->send(new ContactAcknowledgment($contact));

            // ✅ Count success attempt
            RateLimiter::hit($key, $this->decayMinutes * 60);

            return back()->with('success', 'Thank you! We have sent a confirmation email.');

        } catch (\Exception $e) {
            Log::error('Contact form failed: ' . $e->getMessage());

            return back()->withErrors([
                'message' => 'Something went wrong. Please try again.'
            ])->withInput();
        }
    }

}
