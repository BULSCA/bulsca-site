<h1>Entity: {{ $entity->custom_id }}</h1>
<p>Type: {{ $entity->entity_type }}</p>
<p>Display Name: {{ $entity->display_name }}</p>

<h2>Memberships</h2>
<ul>
  @foreach ($entity->memberships as $membership)
    <li>
      Member of: {{ $membership->parent->entityable->name ?? 'Unknown' }}
      (Role: {{ $membership->role }})
    </li>
  @endforeach
</ul>

<h2>Parent Memberships</h2>
<ul>
  @foreach ($entity->parentMemberships as $membership)
    <li>
      Has Member: {{ $membership->child->entityable->display_name }}
    </li>
  @endforeach
</ul>   