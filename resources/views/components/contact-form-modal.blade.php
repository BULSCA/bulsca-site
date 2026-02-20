@props(['show' => false, 'department' => null])

<div 
  x-data="{ open: @js($show) }" 
  x-show="open" 
  @keydown.escape.window="open = false"
  class="fixed inset-0 z-50 overflow-y-auto"
  style="display: @js($show) ? 'block' : 'none'"
>
  <!-- Backdrop -->
  <div 
    @click="open = false" 
    class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
  ></div>

  <!-- Modal -->
  <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <div 
      @click.stop
      class="relative inline-block align-bottom bg-white rounded-lg shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-2xl"
      x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
      x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
      x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
      <!-- Close button -->
      <div class="absolute top-0 right-0 pt-4 pr-4">
        <button
          @click="open = false"
          type="button"
          class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          <span class="sr-only">Close</span>
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal content -->
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Contact BULSCA</h3>

        @if ($errors->any())
          <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <h4 class="font-bold mb-2">Please fix the following errors:</h4>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if (session('success'))
          <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
          </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
          @csrf

          <div>
            <label for="modal-name" class="block text-sm font-medium text-gray-700">Your Name</label>
            <input 
              type="text" 
              id="modal-name" 
              name="name" 
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
              value="{{ old('name') }}" 
              required
            >
          </div>

          <div>
            <label for="modal-email" class="block text-sm font-medium text-gray-700">Your Email</label>
            <input 
              type="email" 
              id="modal-email" 
              name="email" 
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
              value="{{ old('email') }}" 
              required
            >
          </div>

          <div>
            <label for="modal-department" class="block text-sm font-medium text-gray-700">Who would you like to contact?</label>
            <select 
              id="modal-department" 
              name="department" 
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
              required
            >
              <option value="">-- Select a department --</option>
              <option value="chair" @if(old('department') === 'chair' || $department === 'chair') selected @endif>Chair - General inquiries & external organisations</option>
              <option value="secretary" @if(old('department') === 'secretary' || $department === 'secretary') selected @endif>Secretary - Minutes & complaints</option>
              <option value="treasurer" @if(old('department') === 'treasurer' || $department === 'treasurer') selected @endif>Treasurer - Finance & sponsorship</option>
              <option value="development" @if(old('department') === 'development' || $department === 'development') selected @endif>Development Officer - Club development & training</option>
              <option value="recruitment" @if(old('department') === 'recruitment' || $department === 'recruitment') selected @endif>Recruitment Officer - Starting a new club</option>
              <option value="data" @if(old('department') === 'data' || $department === 'data') selected @endif>Data Manager - Website & competition data</option>
              <option value="championships" @if(old('department') === 'championships' || $department === 'championships') selected @endif>Championships Coordinator - Annual championships</option>
              <option value="social" @if(old('department') === 'social' || $department === 'social') selected @endif>Communication Officer - Website & social media</option>
              <option value="welfare" @if(old('department') === 'welfare' || $department === 'welfare') selected @endif>Welfare Officer - Welfare & safeguarding</option>
              <option value="league" @if(old('department') === 'league' || $department === 'league') selected @endif>League Team - League-related matters</option>
              <option value="judges" @if(old('department') === 'judges' || $department === 'judges') selected @endif>Judges Panel - SERCs & competition moderation</option>
            </select>
          </div>

          <div>
            <label for="modal-subject" class="block text-sm font-medium text-gray-700">Subject</label>
            <input 
              type="text" 
              id="modal-subject" 
              name="subject" 
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
              value="{{ old('subject') }}" 
              required
            >
          </div>

          <div>
            <label for="modal-message" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea 
              id="modal-message" 
              name="message" 
              rows="6" 
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
              required
            >{{ old('message') }}</textarea>
            <small class="text-gray-500 mt-1 block">Maximum 5000 characters</small>
          </div>

          <div class="flex justify-end gap-3 pt-4">
            <button
              @click="open = false"
              type="button"
              class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Send Message
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
