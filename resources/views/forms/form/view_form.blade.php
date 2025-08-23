@php
$page = $form->title;
($view_type === 'preview') and $page .= ' - Preview*';
$module = ($view_type === 'preview') ? 'My Form' : config('app.name');

$fields = $form->fields()->filled()->get();
@endphp

@section('title', "{$module} | {$page}")

@extends('layout')

@section('content')
<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">
    <div class="h-full w-full overflow-hidden relative">
        <div class="absolute top-0 right-0 w-full h-full  flex  items-center justify-center head-bg-3  "
            style="background-image: linear-gradient(rgba(0, 0, 0, 0.25),
                   rgba(0, 0, 0, 0.25)), url('storage/photos/freshers/fresher_banner.jpeg');  ">
            <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
            <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                <h1 class="md:text-6xl text-4xl font-bold text-white">Forms</h1>
                <p class="text-white">Welcome to Bulsca Forms testing!</p>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">{{ $page }}</h5>
            </div>

            @if ($form->status === App\Models\Form\Form::STATUS_CLOSED)
                <div class="panel-body">
                    {{ optional($form->availability)->closed_form_message ?? 'Sorry, this form has been closed to responses.' }}
                </div>
            @else
                <div class="panel-body">
                    {!! nl2br(e($form->description)) !!}
                </div>

                <div class="panel-body">
                    <form id="user-form" action="{{ ($view_type === 'form') ? route('forms.responses.store', $form->code) : "#" }}" method="{{ ($view_type === 'form') ? "post" : "get" }}" autocomplete="off">
                        @if ($view_type === 'form') @csrf @endif
                        <div id="form-fields" class="mt-15 mb-15">
                            @php $formatted_fields = []; @endphp
                            @if ($fields->count())
                                {{-- <p class="content-group text-danger"><strong>Fields with * are required</strong></p> --}}
                                @foreach ($fields as $field)
                                    @php $template = get_form_templates($field->template) @endphp
                                    <div class="field" data-id="{{ $field->id }}" data-attribute="{{ $field->attribute }}" data-attribute-type="{{ $template['attribute_type'] === 'string' ? 'single' : 'multiple' }}">
                                        {!! $template['main_template'] !!}
                                    </div>
                                    @php
                                        $only_attributes = ['attribute', 'template', 'question', 'required', 'options'];
                                        $formatted_fields[$field->attribute] = $field->only($only_attributes);
                                    @endphp
                                @endforeach
                            @endif
                        </div>

                        <div class="text-left mt-20">
                            <button id="submit" type="{{ ($view_type === 'form') ? 'submit' : 'button' }}" class="btn btn-primary" data-loading-text="Please Wait..." data-complete-text="Submit Form">Submit Form</button>
                        </div>
                    </form>
                </div>
            @endif
    </div>
</div>
@endsection

@if ($form->status === App\Models\Form\Form::STATUS_OPEN)
    @section('plugin-scripts')
        <script src="{{ asset('assets/js/plugins/uniform.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/autosize.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/noty.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/ion_rangeslider.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/pickadate/picker.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/pickadate/picker.date.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/pickadate/picker.time.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/pickadate/legacy.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/validation/validate.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/validation/additional-methods.min.js') }}"></script>
    @endsection

    @section('page-script')
        <script src="{{ asset('assets/js/custom/pages/validation.js') }}"></script>
        @include('forms.partials._script-view')
    @endsection
@endif
