@foreach ($entities as $entity)
    <div>
        <h3>{{ $entity->custom_id }} ({{ $entity->display_name }})</h3>
        <p>Type: {{ class_basename($entity->entity_type) }}</p>
        <p>Privacy: {{ $entity->privacy_level }}</p>
    </div>
@endforeach   