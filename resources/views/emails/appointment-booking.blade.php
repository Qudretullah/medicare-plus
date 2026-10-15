
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Request Received | Medicare+</title>
</head>

<body style="margin:0;padding:0;background:#F0F3FA;font-family:Arial,Helvetica,sans-serif;color:#465572;">

    <div style="max-width:620px;margin:35px auto;padding:0 15px;">

        <div style="background:#FFFFFF;border:1px solid #DCE3F1;border-radius:16px;overflow:hidden;">

            <!-- EMAIL HEADER -->
            <div style="background:#101D38;padding:30px 25px;text-align:center;">

                <h1 style="color:#FFFFFF;font-size:28px;margin:0;font-weight:700;">
                    Medicare<span style="color:#7798DC;">+</span>
                </h1>

                <p style="color:#C5D2EA;font-size:13px;margin:10px 0 0;">
                    Professional Healthcare, Trusted Care
                </p>

            </div>

            <!-- SUCCESS MESSAGE -->
            <div style="padding:30px 28px 12px;text-align:center;">

                <div style="font-size:38px;color:#3458A4;margin-bottom:12px;">
                    &#10003;
                </div>

                <h2 style="color:#101D38;font-size:23px;margin:0 0 12px;font-weight:600;">
                    Appointment Request Received
                </h2>

                <p style="font-size:14px;line-height:1.8;margin:0;">
                    Hello {{ $appointment->patient_name }},
                    <br>
                    Thank you for choosing Medicare+.
                    We have received your appointment request.
                </p>

            </div>

            <!-- BOOKING REFERENCE -->
            <div style="padding:22px 28px 0;">

                <div style="background:#F0F3FA;border:1px solid #DCE3F1;border-radius:12px;padding:22px;text-align:center;">

                    <p style="font-size:11px;font-weight:700;letter-spacing:1px;color:#73819A;margin:0 0 10px;">
                        YOUR BOOKING REFERENCE
                    </p>

                    <strong style="display:block;color:#3458A4;font-size:25px;letter-spacing:1px;">
                        {{ 'MED-' . str_pad((string) $appointment->id, 6, '0', STR_PAD_LEFT) }}
                    </strong>

                    <div style="margin-top:14px;">
                        <span style="display:inline-block;padding:8px 16px;background:#FFF4DC;color:#956300;border-radius:30px;font-size:12px;font-weight:700;">
                            Pending Approval
                        </span>
                    </div>

                </div>

            </div>

            <!-- APPOINTMENT DETAILS -->
            <div style="padding:26px 28px 0;">

                <h3 style="font-size:17px;color:#101D38;margin:0 0 17px;font-weight:600;">
                    Appointment Details
                </h3>

                <table role="presentation" style="width:100%;border-collapse:collapse;font-size:13px;">
                    <tbody>
                        <tr>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;color:#73819A;">Patient Name</td>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;text-align:right;color:#101D38;font-weight:700;">
                                {{ $appointment->patient_name }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;color:#73819A;">Department</td>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;text-align:right;color:#101D38;font-weight:700;">
                                {{ ucwords(str_replace('-', ' ', $appointment->department)) }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;color:#73819A;">Doctor</td>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;text-align:right;color:#101D38;font-weight:700;">
                                {{ $doctorName }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;color:#73819A;">Date</td>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;text-align:right;color:#101D38;font-weight:700;">
                                {{ $appointment->appointment_date->format('d M Y') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;color:#73819A;">Time</td>
                            <td style="padding:12px 0;border-bottom:1px solid #E7ECF4;text-align:right;color:#101D38;font-weight:700;">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <!-- IMPORTANT NOTICE -->
            <div style="padding:24px 28px 30px;">

                <div style="background:#EEF2FB;border-left:4px solid #3458A4;padding:17px 18px;border-radius:8px;">

                    <p style="margin:0;color:#344766;font-size:13px;line-height:1.8;">
                        <strong>Important:</strong>
                        Your appointment is currently pending approval.
                        Our team will review your request and send you
                        another email once your appointment is approved
                        or rejected.
                    </p>

                </div>

            </div>

            <!-- FOOTER -->
            <div style="background:#F7F9FD;border-top:1px solid #DCE3F1;padding:22px 25px;text-align:center;">

                <p style="font-size:12px;color:#73819A;line-height:1.7;margin:0;">
                    This is an automated notification from Medicare+.
                    Please keep your booking reference for future communication.
                </p>

                <p style="font-size:12px;color:#3458A4;font-weight:700;margin:14px 0 0;">
                    Medicare+ Healthcare
                </p>

            </div>

        </div>

    </div>

</body>
</html>
