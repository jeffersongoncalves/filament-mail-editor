<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        /* CSS Reset */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            border-collapse: collapse;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            display: block;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
            -webkit-font-smoothing: antialiased;
        }

        p {
            margin: 0;
            padding: 0;
        }

        a {
            color: inherit;
        }

        /* Mobile Responsive */
        @media only screen and (max-width: 480px) {
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
            }

            .email-content {
                padding: 16px !important;
            }

            .stack-column {
                display: block !important;
                width: 100% !important;
            }

            img {
                max-width: 100% !important;
                height: auto !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: {{ $settings['bg_color'] ?? '#f8f9fa' }}; font-family: {{ $settings['font_family'] ?? 'Arial, Helvetica, sans-serif' }};">
    <!-- Wrapper Table -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: {{ $settings['bg_color'] ?? '#f8f9fa' }};">
        <tr>
            <td align="center" style="padding: 24px 0;">
                <!--[if mso]>
                <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                <tr>
                <td>
                <![endif]-->
                <!-- Inner Table -->
                <table role="presentation" class="email-container" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; width: 100%; margin: 0 auto; background-color: {{ $settings['content_bg_color'] ?? '#ffffff' }};">
                    <tr>
                        <td class="email-content">
                            {!! $content !!}
                        </td>
                    </tr>
                </table>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
    </table>
</body>
</html>
