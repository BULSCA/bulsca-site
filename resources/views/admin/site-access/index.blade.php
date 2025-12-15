{{-- resources/views/admin/site-access/index.blade.php --}}

<h2>Grant Site Access</h2>
<form action="{{ route('admin.site-access.grant') }}" method="POST" class="space-y-4">
    @csrf
    <input type="email" name="email" placeholder="user@example.com" required>
    
    {{-- Preset scopes --}}
    <div>
        <label>Quick Presets:</label>
        @foreach(config('sso.scope_presets', []) as $presetName => $presetScopes)
            <button type="button" onclick="setScopes({{ json_encode($presetScopes) }})" 
                    class="px-3 py-1 bg-gray-200 rounded">
                {{ ucfirst($presetName) }}
            </button>
        @endforeach
    </div>
    
    {{-- Custom scopes --}}
    <div>
        <label>Custom Scopes (one per line or comma-separated):</label>
        <textarea name="scopes" id="scopesInput" rows="3" placeholder="admin, member, results_uploader"></textarea>
        <small>Examples: admin, official, member, competition_official, results_uploader</small>
    </div>
    
    <textarea name="notes" placeholder="Notes (optional)"></textarea>
    <button type="submit">Grant Access</button>
</form>

{{-- Current access config --}}
@if(!empty(config('sso.accepted_scopes')))
    <div class="alert alert-info">
        ℹ️ This site currently accepts: <strong>{{ implode(', ', config('sso.accepted_scopes')) }}</strong>
    </div>
@else
    <div class="alert alert-success">
        ✅ This site accepts any scope
    </div>
@endif

{{-- User list --}}
<h2>Users with Access ({{ $data['total_count'] ?? 0 }})</h2>
@if(isset($data['all_scopes']))
    <p>All scopes in use: {{ implode(', ', $data['all_scopes']) }}</p>
@endif

<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Name</th>
            <th>Scopes</th>
            <th>Granted</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['users'] ?? [] as $user)
            <tr>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['name'] }}</td>
                <td>
                    @foreach($user['scopes'] as $scope)
                        <span class="badge">{{ $scope }}</span>
                    @endforeach
                </td>
                <td>{{ \Carbon\Carbon::parse($user['granted_at'])->format('Y-m-d') }}</td>
                <td>
                    <button onclick="editScopes('{{ $user['email'] }}', {{ json_encode($user['scopes']) }})">
                        Edit Scopes
                    </button>
                    <form action="{{ route('admin.site-access.revoke') }}" method="POST" style="display:inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ $user['email'] }}">
                        <button type="submit">Revoke All</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
function setScopes(scopes) {
    document.getElementById('scopesInput').value = scopes.join(', ');
}

function editScopes(email, currentScopes) {
    // Show modal or inline edit UI
    alert(`Edit scopes for ${email}. Current: ${currentScopes.join(', ')}`);
}
</script>