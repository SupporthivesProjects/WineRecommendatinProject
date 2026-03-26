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
        
        // Check if IP has reached the maximum attempts
        if (RateLimiter::tooManyAttempts('contact-form:'.$ip, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn('contact-form:'.$ip);
            return back()->withErrors([
                'message' => "Too many attempts. Please try again in " . 
                           ceil($seconds / 60) . " minutes."
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'terms' => 'accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if IP is present
        if (empty($ip)) {
            return back()->withErrors([
                'message' => 'Unable to verify your request. Please try again.'
            ])->withInput();
        }

        // Check if this IP has already submitted 3 or more times
        $submissionCount = ContactRequest::where('ip_address', $ip)->count();
        if ($submissionCount >= $this->maxAttempts) {
            return back()->withErrors([
                'message' => 'You have reached the maximum number of submissions.'
            ]);
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

            $supportEmail = env('SUPPORT_EMAIL');
            // Send acknowledgment email to user
            Mail::to($contact->email)->send(new ContactAcknowledgment($contact));
            
            // Send notification to support team
            //Mail::to($supportEmail)->send(new ContactFormSubmitted($contact));
            
            // Increment the rate limiter
            RateLimiter::hit('contact-form:'.$ip, $this->decayMinutes * 60);

            return redirect()->back()->with('success', 'Thank you for contacting us! We have sent a confirmation email to ' . $contact->email);
            
        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());
            return back()->withErrors([
                'message' => 'An error occurred while processing your request. Please try again.'
            ])->withInput();
        }
    }
}
