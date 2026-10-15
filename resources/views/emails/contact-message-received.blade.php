
<x-mail::message>
# New Contact Message

A new message has been submitted through the Medicare+ website.

**Name:** {{ $contactMessage->name }}

**Email:** {{ $contactMessage->email }}

**Phone:** {{ $contactMessage->phone }}

**Subject:** {{ $contactMessage->subject }}

**Message:**

{{ $contactMessage->message }}

<x-mail::panel>
Received on: {{ $contactMessage->created_at->format('d M Y, h:i A') }}
</x-mail::panel>

Thanks,  
Medicare+ Website
</x-mail::message>
