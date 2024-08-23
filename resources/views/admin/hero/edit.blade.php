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
                this.hero.bg_value = fr.result
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
    
            this.hero.bg_value = color
    
        },
    
        switchBackgroundType(e, type) {
    
    
    
    
            if (type == 'image') {
    
                if ($refs.bgfile.files.length === 0) {
    
    
                    return
                }
    
                var file = $refs.bgfile.files[0]
    
                var fr = new FileReader()
    
                fr.onload = () => {
                    this.hero.bg_value = fr.result
                    this.hero.bg_type = 'image'
    
                }
    
                fr.readAsDataURL(file)
            } else {
                this.hero.bg_value = $refs.bgclr.value || ''
                this.hero.bg_type = 'color'
            }
    
    
    
    
        }
    
    }">
        <x-hero />





        <div class=" container-responsive ">
            <h2>Hero Editor</h2>
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
                            <label for="">Image</label>
                            <input type="radio" x-model="hero.bg_type" @click="(e) => switchBackgroundType(e,'image')"
                                class=" !cursor-pointer" value="image">
                        </div>

                        <div class="form-input radio">
                            <label for="">Colour</label>
                            <input type="radio" x-model="hero.bg_type" @click="(e) => switchBackgroundType(e,'color')"
                                class=" !cursor-pointer" value="color">
                        </div>
                    </div>

                    <div x-show="hero.bg_type == 'color'">
                        <div class="form-input">
                            <label for="">Colour</label>
                            <input type="color" name="" id="" x-ref="bgclr"
                                @input="handleBackgroundColor">
                        </div>
                        <button class="btn btn-thinner" x-show="hero.bg_value !== heroOriginal.bg_value"
                            @click="hero.bg_value = heroOriginal.bg_value; $refs.bgfile.value=null">Reset</button>
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

        </div>


    </div>
@endsection
