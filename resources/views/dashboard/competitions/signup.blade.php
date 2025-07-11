{{-- competitions/signup.blade.php --}}
<form action="{{ route('competitions.signup.store', $comp) }}" method="POST">
    @csrf
    
    @if($signup)
        <h2>Edit Your Signup</h2>
    @else
        <h2>Sign Up for {{ $competition->title }}</h2>
    @endif

    {{-- Dynamic form fields based on signup_data --}}
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" 
               value="{{ old('name', $signup->signup_data['name'] ?? '') }}"
               required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $signup->signup_data['email'] ?? '') }}"
               required>
    </div>

    {{-- Add more fields as needed --}}

    <button type="submit" class="btn btn-primary">
        {{ $signup ? 'Update Signup' : 'Submit Signup' }}
    </button>
</form>
