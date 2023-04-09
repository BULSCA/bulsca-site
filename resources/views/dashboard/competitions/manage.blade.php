@extends('layouts.dashlayout')

@section('title')
(Manage) {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }} | Competitions |
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')



<div class="container-responsive">
  <div class="flex items-center justify-center">
    <div class="flex flex-col">
      <h2 style='margin-bottom: -.25em !important'><span style="font-size: 0.5em !important">Competition Management</span></h2>
      <h2 style='margin-bottom: -.15em !important'><span class="text-bulsca_red font-bold">{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}</span></h2>
      <small class="">
        {{ $comp->when->format('d/m/Y @ h:m A') }}
      </small>
    </div>
    <a href="{{ route('lc-view', Str::lower($comp->hostUni->name) . '-' . $comp->when->format('Y') . '.' . $comp->id) }}" class="btn btn-thinner ml-auto">View</a>
  </div>


  <br>
  <div class="alert">
    <h3>Important!</h3>
    <p>
      Please fill out all of the following by the time your competition entries go out! <br>
      You <strong>don't need to finish</strong> it in one go. It can be amended over time!
    </p>
  </div>
  <br>

  <form action="{{ route('lc-manage-update', ['cid' => $comp->id]) }}" method="post" class="flex flex-col">


    @csrf

    <section>
      <h4>Forms</h4>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-form-input id="form_entry" title="Entry Form URL" type="url" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="form_judges" title="Judges Form URL" type="url" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="form_helpers" title="Helpers Form URL" type="url" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>Timeline</h4>
      <div class=" space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <x-form-input id="timetable_entry_close" title="Entry Close" type="datetime-local" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_entry_close') }}"></x-form-input>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <x-form-input id="timetable_reg_open" title="Registration Open" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_reg_open') }}"></x-form-input>
          <x-form-input id=" timetable_reg_close" title="Registration Closes" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_reg_close') }}"></x-form-input>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <x-form-input id="timetable_sercs_start" title="SERCs Start" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_sercs_start') }}"></x-form-input>
          <x-form-input id="timetable_speeds_start" title="Speeds Start" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_speeds_start') }}"></x-form-input>
          <x-form-input id="timetable_comp_end" title="Competition Ends" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_comp_end') }}"></x-form-input>
        </div>



        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <x-form-input id="timetable_social_open" title="Social Opens" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_social_open') }}"></x-form-input>

          <x-form-input id="timetable_social_end" title="Social Ends" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_social_end') }}"></x-form-input>
          <x-form-input id="timetable_results" title="Results" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_results') }}"></x-form-input>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

          <x-form-input id="timetable_accom_open" title="Accommodation Opens" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_accom_open') }}"></x-form-input>
          <x-form-input id="timetable_accom_close" title="Accommodation Closes" type="time" required="false" defaultValue="{{ $comp->getInfo->getTimetableTime('timetable_accom_close') }}"></x-form-input>
        </div>
      </div>

    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>General Info</h4>

      <div class="grid-3">
        <x-form-input id="general_location" title="Location" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="general_league_event" title="League Event" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="general_required_kit" title="Required Kit" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
      <h5>First Aid Kits</h5>
      <div class="grid-3 mb-3">
        <x-form-input id="general_fak_full" title="Full" type="checkbox" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="general_fak_travel" title="Travel" type="checkbox" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
      <h5>Officials</h5>
      <div class="grid-3">
        <x-form-input id="general_official_headref" title="Head Ref" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="general_official_wetserc" title="Wet SERC Writer" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="general_official_dryserc" title="Dry SERC Writer" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>Pool</h4>
      <div class="grid-3">
        <x-form-input id="pool_location" title="Location" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="pool_length" title="Length (m)" type="number" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="pool_lanes" title="Lanes" type="number" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
      <x-form-input id="pool_extra" title="Extra Info" required="false" :defaultObject="$comp->getInfo"></x-form-input>
    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>Registration</h4>
      <div class="grid-3">
        <x-form-input id="registration_location" title="Location" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
      <x-form-input id="registration_extra" title="Extra Info" required="false" :defaultObject="$comp->getInfo"></x-form-input>
    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>Teams</h4>
      <div class="grid-3">
        <x-form-input id="teams_limit" title="Max" type="number" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="teams_cost" title="Cost per team" type="currency" defaultValue="0" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
      <x-form-input id="teams_extra" title="Extra Info" required="false" :defaultObject="$comp->getInfo"></x-form-input>
    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>Food</h4>
      <div class="grid-3">
        <x-form-input id="food_cost" title="Cost" type="currency" defaultValue="0" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
      <x-form-input id="food_options" title="Options" required="false" :defaultObject="$comp->getInfo"></x-form-input>
    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>Social</h4>
      <div class="grid-3">
        <x-form-input id="social_location" title="Location" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="social_cost" title="Cost" type="currency" defaultValue="0" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="social_theme" title="Theme" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>

    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>Accommodation</h4>
      <div class="grid-3">
        <x-form-input id="accom_location" title="Location" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="accom_cost" title="Cost" type="currency" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
      <x-form-input id="accom_extra" title="Extra Info" required="false" :defaultObject="$comp->getInfo"></x-form-input>
    </section>


    <br>
    <hr><br><br>

    <section>
      <h4>Contact Info</h4>
      <h5>Organiser</h5>
      <div class="grid-3">
        <x-form-input id="contact_organiser_name" title="Name" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="contact_organiser_email" title="Email" type="email" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="contact_organiser_phone" title="Phone" type="tel" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
      <h5>Emergency</h5>
      <div class="grid-3">
        <x-form-input id="contact_emergency_name" title="Name" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="contact_emergency_email" title="Email" type="email" required="false" :defaultObject="$comp->getInfo"></x-form-input>
        <x-form-input id="contact_emergency_phone" title="Phone" type="tel" required="false" :defaultObject="$comp->getInfo"></x-form-input>
      </div>
    </section>

    <br>
    <hr><br><br>

    <section>
      <h4>Other Details</h4>
      <textarea hidden name="extra_info" id="editor" class="h-[52vh]">{{ $comp->getInfo->extra_info }}</textarea>
    </section>

    <br>
    <br>

    <button class="btn btn-thinner btn-save" type="submit">Save</button>

  </form>








</div>

<hr>
<p class="text-center my-4 text-lg">
  <strong>The results and info pack forms below are seperate to the above!</stro>
</p>
<hr>


<div class="container-responsive overflow-hidden" id="info-pack">
  <h3>Info Pack</h3>
  @if ($comp->getPackResource()->first())
  <div class="flex items-center space-x-4">
    <x-resource-download :file="$comp->getPackResource()->first()" />
    <a href="manage/remove-pack#info-pack" class="">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 hover:text-bulsca_red transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </a>
  </div>

  <hr class="my-5">

  @endif
  <h4>
    Upload/Change Info Pack
  </h4>
  <form action="manage/upload-pack#info-pack" class="inline-block overflow-hidden" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-input">
      <label for="upload-file">File</label>
      <input id="upload-file" class="input file" name="results" required type="file">
    </div>
    <button class="btn btn-thinner">Upload</button>
  </form>


</div>

<div class="container-responsive overflow-hidden" id="results">
  <h3>Results</h3>
  @if ($comp->hasResults())
  <div class="flex items-center space-x-4">
    <x-resource-download :file="$comp->getResults()" />
    <a href="manage/remove-results#results" class="">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 hover:text-bulsca_red transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </a>
  </div>

  <hr class="my-5">

  @endif
  <h4>
    Upload/Change Results
  </h4>
  <form action="manage/upload-results#results" class="inline-block overflow-hidden" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-input">
      <label for="upload-file">File</label>
      <input id="upload-file" class="input file" name="results" required type="file">
    </div>
    <button class="btn btn-thinner">Upload</button>
  </form>


</div>





<script src="/storage/ckeditor.js"></script>

<script>
  const watchdog = new CKSource.EditorWatchdog();

  window.watchdog = watchdog;

  watchdog.setCreator((element, config) => {
    return CKSource.Editor
      .create(element, config)
      .then(editor => {




        return editor;
      })
  });

  watchdog.setDestructor(editor => {



    return editor.destroy();
  });

  watchdog.on('error', handleError);

  watchdog
    .create(document.querySelector('#editor'), {

      licenseKey: '',



    })
    .catch(handleError);

  function handleError(error) {
    console.error('Oops, something went wrong!');
    console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
    console.warn('Build id: 6ejwh9b4xfpx-l949vrtw2lll');
    console.error(error);
  }
</script>

<script>
  var currencyInputs = document.querySelectorAll('input[type="currency"]')
  var currency = 'GBP' // https://www.currency-iso.org/dam/downloads/lists/list_one.xml

  // format inital value
  currencyInputs.forEach(currencyInput => {
    onBlur({
      target: currencyInput
    })

    // bind event listeners
    currencyInput.addEventListener('focus', onFocus)
    currencyInput.addEventListener('blur', onBlur)


    function localStringToNumber(s) {
      return Number(String(s).replace(/[^0-9.-]+/g, ""))
    }

    function onFocus(e) {
      var value = e.target.value;
      e.target.value = value ? localStringToNumber(value) : ''
    }

    function onBlur(e) {
      var value = e.target.value

      var options = {
        maximumFractionDigits: 2,
        currency: currency,
        style: "currency",
        currencyDisplay: "symbol"
      }

      e.target.value = (value || value === 0) ?
        localStringToNumber(value).toLocaleString(undefined, options) :
        ''
    }
  })
</script>


@endsection