@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

# New Contact Form Submission

You have received a new contact form submission with the following details:

- **Name:** {{ $contact->name }}
- **Email:** {{ $contact->email }}
- **Phone:** {{ $contact->phone }}
- **Message:**  
{{ $contact->message }}

---

This email was sent from the contact form on {{ config('app.name') }}.

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
@endcomponent
@endslot
@endcomponent
