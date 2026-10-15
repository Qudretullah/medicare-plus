
@php
    $isApproved = $appointment->status === 'approved';

    $bookingReference = 'MED-' . str_pad(
        (string) $appointment->id,
        6,
        '0',
        STR_PAD_LEFT
    );

    $appointmentDate = \Carbon\Carbon::parse(
        $appointment->appointment_date
    )->format('d M Y');

    $appointmentTime = \Carbon\Carbon::parse(
        $appointment->appointment_time
    )->format('h:i A');

    $departmentName = ucwords(
        str_replace('-', ' ', $appointment->department)
    );

    $statusText = $isApproved ? 'Approved' : 'Rejected';

    $statusColor = $isApproved ? '#21866b' : '#bd5260';

    $statusBackground = $isApproved ? '#e8f7f1' : '#fff0f1';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Medicare+ Appointment Update</title>
</head>

<body style="
    margin:0;
    padding:35px 12px;
    background-color:#f3fafd;
    font-family:Arial,Helvetica,sans-serif;
    color:#526e82;
">

    <!-- EMAIL CONTAINER -->
    <table
        role="presentation"
        cellpadding="0"
        cellspacing="0"
        border="0"
        width="100%"
        style="max-width:620px;margin:0 auto;"
    >
        <tr>
            <td style="
                background:#ffffff;
                border:1px solid #dcebf3;
                border-radius:18px;
                overflow:hidden;
            ">

                <!-- HEADER -->
                <table
                    role="presentation"
                    width="100%"
                    cellpadding="0"
                    cellspacing="0"
                    style="background:#5599c3;"
                >
                    <tr>
                        <td
                            align="center"
                            style="padding:32px 20px;"
                        >
                            <div style="
                                font-size:31px;
                                font-weight:700;
                                letter-spacing:-1px;
                                color:#ffffff;
                            ">
                                Medicare+
                            </div>

                            <p style="
                                margin:10px 0 0;
                                font-size:13px;
                                color:#edf8ff;
                            ">
                                Your Health, Our Priority
                            </p>
                        </td>
                    </tr>
                </table>


                <!-- EMAIL CONTENT -->
                <table
                    role="presentation"
                    width="100%"
                    cellpadding="0"
                    cellspacing="0"
                >
                    <tr>
                        <td style="padding:35px 32px;">

                            <!-- STATUS -->
                            <div style="text-align:center;">

                                <span style="
                                    display:inline-block;
                                    padding:10px 19px;
                                    background:{{ $statusBackground }};
                                    color:{{ $statusColor }};
                                    font-size:13px;
                                    font-weight:700;
                                    border-radius:30px;
                                ">
                                    Appointment {{ $statusText }}
                                </span>

                            </div>


                            <!-- HEADING -->
                            <h1 style="
                                margin:28px 0 16px;
                                color:#476c89;
                                font-size:25px;
                                font-weight:600;
                                line-height:1.35;
                                text-align:center;
                            ">
                                @if ($isApproved)
                                    Your Appointment Is Confirmed
                                @else
                                    Appointment Request Update
                                @endif
                            </h1>


                            <!-- GREETING -->
                            <p style="
                                margin:0 0 16px;
                                font-size:15px;
                                line-height:1.8;
                            ">
                                Dear {{ $appointment->patient_name }},
                            </p>


                            <!-- MESSAGE -->
                            <p style="
                                margin:0 0 24px;
                                font-size:14px;
                                line-height:1.9;
                            ">
                                @if ($isApproved)

                                    We are pleased to inform you that
                                    your appointment request at Medicare+
                                    has been approved.

                                    Please review your appointment
                                    details below.

                                @else

                                    We regret to inform you that
                                    your appointment request at Medicare+
                                    could not be approved.

                                    You may contact our clinic for
                                    assistance or submit a new
                                    appointment request.

                                @endif
                            </p>


                            <!-- BOOKING REFERENCE -->
                            <div style="
                                background:#f3fafd;
                                border:1px solid #dcebf3;
                                border-radius:12px;
                                padding:20px;
                                margin-bottom:25px;
                                text-align:center;
                            ">

                                <p style="
                                    margin:0 0 8px;
                                    font-size:11px;
                                    font-weight:700;
                                    letter-spacing:1.5px;
                                    color:#7a92a3;
                                ">
                                    BOOKING REFERENCE
                                </p>

                                <div style="
                                    color:#397fa9;
                                    font-size:25px;
                                    font-weight:700;
                                    letter-spacing:1px;
                                ">
                                    {{ $bookingReference }}
                                </div>

                            </div>


                            <!-- APPOINTMENT DETAILS -->
                            <h2 style="
                                margin:0 0 16px;
                                font-size:17px;
                                font-weight:600;
                                color:#476c89;
                            ">
                                Appointment Details
                            </h2>

                            <table
                                role="presentation"
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                style="
                                    border:1px solid #dcebf3;
                                    border-radius:12px;
                                    border-collapse:separate;
                                    border-spacing:0;
                                "
                            >

                                @foreach ([
                                    'Patient Name' => $appointment->patient_name,
                                    'Department' => $departmentName,
                                    'Doctor' => $doctorName,
                                    'Date' => $appointmentDate,
                                    'Time' => $appointmentTime,
                                    'Status' => $statusText,
                                ] as $label => $value)

                                    <tr>
                                        <td style="
                                            padding:13px 15px;
                                            border-bottom:1px solid #eef3f7;
                                            font-size:13px;
                                            color:#7a92a3;
                                            width:43%;
                                        ">
                                            {{ $label }}
                                        </td>

                                        <td style="
                                            padding:13px 15px;
                                            border-bottom:1px solid #eef3f7;
                                            font-size:13px;
                                            font-weight:600;
                                            color:#476c89;
                                            text-align:right;
                                        ">
                                            {{ $value }}
                                        </td>
                                    </tr>

                                @endforeach

                            </table>


                            <!-- ADDITIONAL MESSAGE -->
                            <div style="
                                margin-top:25px;
                                padding:18px;
                                border-left:3px solid #5599c3;
                                background:#f3fafd;
                                border-radius:6px;
                            ">

                                <p style="
                                    margin:0;
                                    font-size:13px;
                                    line-height:1.8;
                                    color:#526e82;
                                ">
                                    @if ($isApproved)

                                        Please arrive on time for
                                        your scheduled appointment.
                                        If you need assistance,
                                        contact the Medicare+ team.

                                    @else

                                        If you would like to book
                                        another appointment, please
                                        visit our website or contact
                                        our clinic for further guidance.

                                    @endif
                                </p>

                            </div>


                            <!-- CLOSING -->
                            <p style="
                                margin:28px 0 0;
                                font-size:14px;
                                line-height:1.8;
                            ">
                                Thank you for choosing Medicare+.
                            </p>

                            <p style="
                                margin:12px 0 0;
                                color:#476c89;
                                font-size:14px;
                                font-weight:700;
                            ">
                                Medicare+ Team
                            </p>

                        </td>
                    </tr>
                </table>

            </td>
        </tr>


        <!-- FOOTER -->
        <tr>
            <td
                align="center"
                style="padding:25px 18px;"
            >
                <p style="
                    margin:0 0 7px;
                    font-size:12px;
                    color:#7a92a3;
                ">
                    Medicare+ — Your Health, Our Priority
                </p>

                <p style="
                    margin:0;
                    font-size:11px;
                    color:#9aafbe;
                    line-height:1.7;
                ">
                    This is an automated appointment notification.
                    Please do not reply directly to this email.
                </p>
            </td>
        </tr>

    </table>

</body>
</html>
