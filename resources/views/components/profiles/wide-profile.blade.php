<div class="md:flex-[1] flex-1">
    <div class="flex flex-col justify-between items-center rounded-md border no-underline text-center overflow-hidden min-h-80 w-56">
        <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center mt-4 mx-4">
            <img src="{{ $member->image_path ? route('image', $member->image_path) : '/storage/logo/blogo.png' }}" class="w-full h-full" alt="">
        </div>
        <h3 class="header header-smallish px-4">
            {{ $member->display_name }}
        </h3>
        <div class="bg-bulsca w-full font-semibold text-white p-2 rounded-b text-center">
            {{ $member->parentMembership?->parent->display_name ?? 'No parent' }}
        </div>
    </div>
</div>
