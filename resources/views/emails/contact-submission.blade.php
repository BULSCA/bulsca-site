
<div class="es-p20t es-p20b es-p30r es-p30l es-m-txt-l">
    <h2>New Contact Form Submission</h2>
    
    <p><strong>From:</strong> {{ $senderName }} ({{ $senderEmail }})</p>
    <p><strong>Department:</strong> {{ ucfirst(str_replace(['_', '-'], ' ', $department)) }}</p>
    <p><strong>Subject:</strong> {{ $messageSubject }}</p>
    
    <hr>
    
    <h3>Message:</h3>
    <p>{!! nl2br(e($messageContent)) !!}</p>
</div>