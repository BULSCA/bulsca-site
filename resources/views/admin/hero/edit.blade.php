@extends('layouts.adminlayout')

@section('content')
    {{-- remove h-100 and revert back to just h-50 once freshers page goes --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <div x-data="{
        showHeaders: true,
        hero: {{ json_encode($hero->getAttributes()) }},
    
        heroOriginal: {{ json_encode($hero->getAttributes()) }},
    
        was: {
            bg_value: '',
        },
    
        handleBackgroundChange(e) {
    
            var file = e.target.files[0]
    
            var fr = new FileReader()
    
            fr.onload = () => {
                this.hero.bg_value = `background-image: url(${fr.result})`
            }
    
            fr.readAsDataURL(file)
        },
    
        handleLogoChange(e) {
            var file = e.target.files[0]
    
            var fr = new FileReader()
    
            fr.onload = () => {
                this.hero.header_logo = fr.result
            }
    
            fr.readAsDataURL(file)
        },
    
        handleBackgroundColor(e) {
            var color = e.target.value
    
            this.hero.bg_value = `background: ${color}`
    
        },
    
        switchBackgroundType(e, type) {
    
    
    
    
            if (type == 'image') {
    
                if ($refs.bgfile.files.length === 0) {
                    this.hero.bg_value = this.heroOriginal.bg_value
                    this.hero.bg_type = 'image'
    
                    return
                }
    
                var file = $refs.bgfile.files[0]
    
                var fr = new FileReader()
    
                fr.onload = () => {
                    this.hero.bg_value = `background-image: url(${fr.result})`
                    this.hero.bg_type = 'image'
    
                }
    
                fr.readAsDataURL(file)
            } else {
                this.hero.bg_value = `background: ${$refs.bgclr.value}`
                this.hero.bg_type = 'color'
            }
    
    
    
    
        },
    
        save() {
    
            var data = new FormData()
    
            data.append('hero', JSON.stringify(this.hero))
            data.append('_token', '{{ csrf_token() }}')
    
            var url = '/admin/hero/{{ $hero->id }}'
    
            if (this.hero.id == -1) {
                url = '/admin/hero/create'
            }
    
            fetch(url, {
                    method: 'POST',
                    body: data
                }).then(res => res.json())
                .then(data => {
                    if (data.message) {
                        showNotification('Saved Hero')
    
                        if (data.id) {
                            window.location = '/admin/hero/' + data.id + '/edit'
                        }
    
                    } else {
                        alert('Error')
                    }
                })
    
        },
    
    
    
    }" x-init="hero.enabled = hero.enabled === 1">
        <x-hero :edit="$hero" />





        <div class=" container-responsive ">
            <div class="flex justify-between items-center">
                <div class="form-input ">
                    <label for="">Name</label>
                    <input type="text" x-model="hero.name" required>
                </div>
                <button class="btn btn-save btn-thinner" @click="save">Save</button>
            </div>

            <div class="form-input checkbox">
                <label for="">Enabled</label>
                <input type="checkbox" x-model="hero.enabled">
            </div>

            <br>

            <div class="form-input">
                <label for="">Content</label>
                <textarea name="" class="input" id="" cols="30" rows="10" x-model="hero.content"></textarea>
            </div>


            <h3>Elements</h3>

            <div class="grid-2">
                <div>
                    <h5 class="hmb-0">Background</h5>

                    <div class="flex space-x-4 text-sm">
                        <div class="form-input radio">
                            <label for="r-image">Image</label>
                            <input type="radio" id="r-image" x-model="hero.bg_type"
                                @click="(e) => switchBackgroundType(e,'image')" class=" !cursor-pointer" value="image">
                        </div>

                        <div class="form-input radio">
                            <label for="r-clr">Colour</label>
                            <input type="radio" id="r-clr" x-model="hero.bg_type"
                                @click="(e) => switchBackgroundType(e,'color')" class=" !cursor-pointer" value="color">
                        </div>
                    </div>

                    <div x-show="hero.bg_type == 'color'">
                        <div class="form-input">
                            <label for="">Colour</label>
                            <input type="color" name="" id="" x-ref="bgclr"
                                @input="handleBackgroundColor">
                        </div>
                        <button class="btn btn-thinner" x-show="hero.bg_value !== heroOriginal.bg_value"
                            @click="hero.bg_value = heroOriginal.bg_value; hero.bg_type='image'">Reset</button>
                    </div>
                    <div x-show="hero.bg_type == 'image'">
                        <div class="form-input">
                            <label for="">Background</label>
                            <input type="file" name="" class=" file" x-ref="bgfile" id=""
                                @change="handleBackgroundChange">
                        </div>
                        <button class="btn btn-thinner" x-show="hero.bg_value !== heroOriginal.bg_value"
                            @click="hero.bg_value = heroOriginal.bg_value; $refs.bgfile.value=null">Reset</button>
                    </div>


                </div>
                <div>
                    <div class="form-input">
                        <label for="">Logo</label>
                        <input type="file" name="" class=" file" x-ref="logofile" id=""
                            @change="handleLogoChange">
                    </div>
                    <button class="btn btn-thinner" x-show="hero.header_logo !== heroOriginal.header_logo"
                        @click="hero.header_logo = heroOriginal.header_logo; $refs.logofile.value=null">Reset</button>
                    <button class="btn btn-thinner" @click="hero.header_logo = ''">No Logo</button>
                </div>
            </div>
            <br>
            <h3>Activation</h3>

            <div class="grid-2">
                <div class="flex space-x-4 text-sm">
                    <div class="form-input radio">
                        <label for="">Manual</label>
                        <input type="radio" x-model="hero.activation_type" class=" !cursor-pointer" value="manual">
                    </div>

                    <div class="form-input radio">
                        <label for="">Time</label>
                        <input type="radio" x-model="hero.activation_type" class=" !cursor-pointer" value="time">
                    </div>

                    <div class="form-input radio">
                        <label for="">Competition</label>
                        <input type="radio" x-model="hero.activation_type" class=" !cursor-pointer" value="competition">
                    </div>
                </div>

                <div x-show="hero.activation_type == 'manual'">
                    <p>This hero will aways show when enabled, unless a time based or competition based one is active and
                        current</p>
                </div>

                <div x-show="hero.activation_type == 'time'" class="grid-2">
                    <div class="form-input radio">
                        <label for="">From</label>
                        <input type="datetime-local" x-model="hero.valid_from">
                    </div>
                    <div class="form-input radio">
                        <label for="">To</label>
                        <input type="datetime-local" x-model="hero.valid_to">
                    </div>
                </div>

                <div x-show="hero.activation_type == 'competition'">
                    <p>This hero will display for 7 days before a competition. Use the following placeholders:
                        %competition_name% %competition_link%</p>
                </div>
            </div>

            <br>

            <h3>Delete</h3>

            <form method="post" action="{{ route('admin.hero.delete', $hero) }}"
                onsubmit='return confirm("Are you sure?")'>
                @csrf
                <button class="btn btn-danger btn-thinner">Delete</button>
            </form>


        </div>


    </div>
@endsection
