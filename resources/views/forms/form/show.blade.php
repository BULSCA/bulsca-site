@php
	$page_data = [
		'has_sticky_sidebar' => true,
		'classes' => ['body' => ' sidebar-xs has-detached-right']
    ];

    $fields = $form->fields;

    $current_user = auth()->user();
@endphp

@extends('layout', $page_data)

@section('title', "My Forms | {$form->title}")

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


<div class="container-responsive">
    <div class="flex items-center ">
        <div class="flex flex-col">

            <h2 class="" style='margin-bottom: -.25em !important'><span style="font-size: 0.5em !important">Hello</span></h2>
            <h2 class="   " style='margin-bottom: -.25em !important'><span
                    class="text-bulsca_red font-bold">{{ auth()->user()->name }}</span></h2>
            
            <small class="">
                @if (auth()->user()->getHomeUni())
                    Associated with {{ auth()->user()->getHomeUni()->name }} University
                    @if (auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id))
                        <small>(Admin)</small>
                    @endif
                @else
                    No Associated University!
                @endif
            </small>

        </div>

        <a href="{{ route('forms.create') }}" class="btn btn-thinner ml-auto">Create a Form</a>

    </div>

    <hr class="my-5">

    <h3 class="">
        Your Forms
    </h3>



    @include('partials.alert', ['name' => 'show'])

    <div class="panel panel-flat">
        <div class="panel-heading">
            @php $symbol = $form::getStatusSymbols()[$form->status]; @endphp
            <h5 class="panel-title">{{ $form->title }} <span class="label bg-{{ $symbol['color'] }} position-left">{{ $symbol['label'] }}</span></h5>
            <div class="heading-elements">
                <div class="btn-group heading-btn">
                    @include('forms.partials._form-menu')
                </div>
            </div>
        </div>
        <div class="panel-body">
            {!! nl2br(e($form->description)) !!}
        </div>
    </div>

    <div class="panel panel-body">
        In order to create a form, you need to click on any on the question type in the presentation section (right sidebar) below. Please ensure that you fill in the appropriate field before submitting.
    </div>

    <div class="container-detached">
        <div class="content-detached">
            <form id="create-form" action="{{ route('forms.draft', $form->code) }}" method="post" autocomplete="off">
                @csrf
                <div class="questions">
                    @php $formatted_fields = []; @endphp
                    @if ($fields->count())
                        @foreach ($fields as $field)
                            <div class="filled" data-id="{{ $field->id }}" data-attribute="{{ $field->attribute }}">
                                @php $template = get_form_templates($field->template) @endphp
                                {!! $template['sub_template'] !!}
                            </div>
                            @php
                                $only_attributes = ['attribute', 'template', 'question', 'required', 'options'];
                                ($template['attribute_type'] === 'array') and array_push($only_attributes, 'options');
                                $formatted_fields[$field->attribute] = $field->only($only_attributes);
                            @endphp
                        @endforeach
                    @endif
                </div>

                <div class="panel panel-body submit hidden">
                    <div class="text-right">
                        <button type="submit" class="btn btn-success btn-xs" id="submit" data-loading-text="Saving..." data-complete-text="Save">Save</button>
                        @php $form_is_ready = in_array($form->status, [$form::STATUS_PENDING, $form::STATUS_OPEN, $form::STATUS_CLOSED]); @endphp
                        <a href="{{ ($form_is_ready) ? route('forms.preview', $form->code) : 'javascript:void(0)' }}" class="btn btn-primary btn-xs position-right{{ ($form_is_ready) ? '' : ' hidden' }}" target="_blank" id="form-preview">Preview</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="sidebar-detached">
        <div class="sidebar sidebar-default">
            <div class="sidebar-content">
                <div class="sidebar-category">
                    <div class="category-title">
                        <span>Presentation</span>
                        <ul class="icons-list">
                            <li><a href="#" data-action="collapse"></a></li>
                        </ul>
                    </div>

                    <div class="category-content no-padding">
                        <ul class="navigation navigation-alt navigation-accordion" data-form="{{ $form->code }}">
                            <li class="navigation-header">Select a Question Type</li>
                            <li><a href="javascript:void()" class="question-template" data-id="short-answer"><i class="icon-minus3"></i> Short Answer</a></li>
                            <li><a href="javascript:void()" class="question-template" data-id="long-answer"><i class="icon-menu7"></i> Long Answer</a></li>
                            <li class="navigation-divider"></li>
                            <li><a href="javascript:void()" class="question-template" data-id="multiple-choices"><i class="icon-radio-checked"></i> Multiple Choice</a></li>
                            <li><a href="javascript:void()" class="question-template" data-id="checkboxes"><i class="icon-checkbox-checked"></i> Chechboxes</a></li>
                            <li><a href="javascript:void()" class="question-template" data-id="drop-down"><i class="icon-circle-down2"></i> Drop-down</a></li>
                            <li class="navigation-divider"></li>
                            <li><a href="javascript:void()" class="question-template" data-id="linear-scale"><i class="icon-move-horizontal"></i> Linear Scale</a></li>
                            <li class="navigation-divider"></li>
                            <li><a href="javascript:void()" class="question-template" data-id="date"><i class="icon-calendar3"></i> Date</a></li>
                            <li><a href="javascript:void()" class="question-template" data-id="time"><i class="icon-alarm"></i> Time</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeWhen(($form->status === $form::STATUS_OPEN), 'forms.partials._form-share')

    @includeWhen(($form->user_id === $current_user->id), 'forms.partials._form-collaborate')

    @include('forms.partials._form_availability')

</div>
@endsection

@section('plugin-scripts')
	<script src="{{ asset('assets/js/plugins/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/autosize.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/noty.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap_select.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/validation/validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/validation/additional-methods.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/custom/pages/validation.js') }}"></script>
    <script src="{{ asset('assets/js/custom/detached-sticky.js') }}"></script>
    @include('forms.partials._script-show')
    @stack('script')
@endsection
