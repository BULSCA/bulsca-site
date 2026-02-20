<div class="es-p20t es-p20b es-p30r es-p30l es-m-txt-l">
    <p>Dear {{ $senderName }},</p>
    
    <p>We have received your message and forwarded it to the {{ ucfirst(str_replace(['_', '-'], ' ', $department)) }} team.</p>
    
    <p>
        <strong>Your message subject:</strong>
        <br>
        <i>{{ $messageSubject }}</i>
        <br>
    </p>
    
    <p>Our team will review your message and get back to you as soon as possible.</p>
    
    <p>If you have an urgent matter, please reach out through alternative channels, or contact our Chair directly.</p>
    
    <p>Best regards,<br>
    The BULSCA Team</p>
</div>