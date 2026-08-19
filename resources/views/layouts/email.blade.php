<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Email' }}</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF7F2; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px;">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0BA20B 0%, #087A08 100%); padding: 30px 40px; border-radius: 8px 8px 0 0; text-align: center;">
            <div style="color: #ffffff; font-size: 28px; font-weight: bold; letter-spacing: 1px;">
                {{ $association->nom ?? 'Écho & Culture' }}
            </div>
            <div style="color: #ffffff; font-size: 12px; margin-top: 8px; opacity: 0.9; text-transform: uppercase; letter-spacing: 2px;">
                Association Culturelle
            </div>
        </div>
        
        <!-- Content -->
        <div style="background-color: #ffffff; padding: 40px; border-radius: 0 0 8px 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 4px solid #0BA20B; border-right: 4px solid #0BA20B; border-bottom: 4px solid #0BA20B;">
            @yield('content')
        </div>
        
        <!-- Footer -->
        <div style="margin-top: 30px; text-align: center; color: #8C766B; font-size: 12px;">
            <p style="margin: 0 0 10px 0;">
                &copy; {{ date('Y') }} {{ $association->nom ?? 'Association Écho & Culture' }}. Tous droits réservés.
            </p>
            <p style="margin: 0; color: #6B574F;">
                Si vous n'avez pas demandé cet email, aucune action supplémentaire n'est requise.
            </p>
        </div>
    </div>
</body>
</html>
