
return back()
    ->with(
        'success',
        'Your appointment request has been submitted successfully!'
    )
    ->with(
        'booking_reference',
        'MED-' . str_pad(
            (string) $appointment->id,
            6,
            '0',
            STR_PAD_LEFT
        )
);
