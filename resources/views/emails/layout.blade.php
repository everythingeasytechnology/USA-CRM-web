<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Anti Gravity CMS Notification' }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .header { background-color: #0f172a; padding: 24px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 20px; letter-spacing: -0.025em; font-weight: 700; }
        .content { padding: 32px 24px; font-size: 14px; line-height: 1.6; }
        .content h2 { margin-top: 0; font-size: 18px; color: #0f172a; font-weight: 700; }
        .footer { background-color: #f8fafc; padding: 16px 24px; text-align: center; font-size: 11px; color: #64748b; border-top: 1px solid #e2e8f0; }
        .highlight-box { background-color: #f1f5f9; border-radius: 8px; padding: 16px; margin: 20px 0; border: 1px solid #e2e8f0; }
        .badge { display: inline-block; padding: 2px 8px; font-size: 11px; font-weight: 600; border-radius: 9999px; background-color: #e0f2fe; color: #0369a1; }
        .invoice-table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 13px; }
        .invoice-table th { text-align: left; padding: 8px; border-bottom: 2px solid #e2e8f0; color: #64748b; }
        .invoice-table td { padding: 8px; border-bottom: 1px solid #f1f5f9; }
        .invoice-total { text-align: right; font-weight: bold; font-size: 14px; margin-top: 16px; color: #0f172a; }
        .btn { display: inline-block; padding: 10px 20px; font-size: 13px; font-weight: 600; color: #ffffff !important; background-color: #2563eb; border-radius: 6px; text-decoration: none; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Anti Gravity CMS</h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            <p>Sent automatically by Anti Gravity CMS. © {{ date('Y') }} EverythingEasy. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
