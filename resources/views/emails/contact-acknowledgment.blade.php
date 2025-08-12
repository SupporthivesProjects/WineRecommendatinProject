@component('mail::message')
# Thank You for Contacting Us

Hello {{ $contact->name }},

We've received your message and appreciate you reaching out to us. Our team will review your inquiry and get back to you as soon as possible.

**Your Message:**  
{{ $contact->message }}

**Reference Number:** #{{ $contact->id }}

If you have any additional information to add to your inquiry, please reply to this email.

Best regards,  
{{ config('app.name') }}

---

<small>
This is an automated message. Please do not reply to this email.  
If you didn't submit this request, please contact our support team immediately.
</small>
@endcomponent
