<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Preview</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #ffffff;
        }

        /* Client simulation styles */
        @php
            $client = $client ?? 'gmail';
        @endphp

        @if ($client === 'gmail')
        /* Gmail strips <style> tags, so we simulate that by keeping it minimal */
        body { background-color: #ffffff; }
        .email-wrapper { max-width: 600px; margin: 0 auto; }
        @elseif ($client === 'outlook')
        /* Outlook: simulate word-rendering quirks */
        body { background-color: #f5f5f5; }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            font-family: Calibri, Arial, sans-serif;
        }
        img { -ms-interpolation-mode: bicubic; }
        table { border-collapse: collapse; }
        @elseif ($client === 'apple')
        /* Apple Mail: supports dark mode */
        body { background-color: #ffffff; }
        .email-wrapper { max-width: 600px; margin: 0 auto; }
        @media (prefers-color-scheme: dark) {
            body { background-color: #1a1a1a !important; color: #ffffff !important; }
            .email-wrapper { background-color: #1a1a1a !important; }
        }
        @elseif ($client === 'mobile')
        /* Mobile: constrained width */
        body { background-color: #ffffff; max-width: 375px; margin: 0 auto; }
        .email-wrapper { max-width: 375px; margin: 0 auto; }
        table { max-width: 100% !important; }
        img { max-width: 100% !important; height: auto !important; }
        /* Force stacking */
        .email-col { width: 100% !important; display: block !important; }
        @endif
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: {{ $settings['bg_color'] ?? '#f8f9fa' }};">
            <tr>
                <td align="center" style="padding: 0;">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width: 600px; width: 100%; background-color: #ffffff;">
                        <tr>
                            <td>
                                {!! $content !!}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <script>
        // Listen for postMessage updates from parent
        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'blocks-update') {
                // Reload with new data
                window.location.reload();
            }
        });

        // Auto-resize iframe
        function notifyParentHeight() {
            const height = document.documentElement.scrollHeight;
            window.parent.postMessage({ type: 'iframe-height', height: height }, '*');
        }

        window.addEventListener('load', notifyParentHeight);
        new MutationObserver(notifyParentHeight).observe(document.body, { childList: true, subtree: true });
    </script>
</body>
</html>
