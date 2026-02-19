@extends('layout')

@section('title')
Privacy-policy |
@endsection

@section('content')

<x-page-banner
  title="Privacy Policy"
  :snowContainer="true"
/>

<div class="container-responsive w-[90%]">
  <h1 class="header header-large">
    Privacy Policy
  </h1>
  <p>This privacy policy applies to the BULSCA internal login system and related services.</p>
  <br><br>
  <h2 class="header header-smallish">What Data We Collect</h2>
  <p>We only create internal login credentials for BULSCA volunteers and committee. No personal data is collected from the public or external users.</p>
  <br><br>
  <h2 class="header header-smallish">How We Use Data</h2>
  <p>Login credentials are used solely for authentication and access control within our internal systems. We do not share, sell, or use this data for any other purpose.</p>
  <br><br>
  <!--
  <h2 class="header header-smallish">Third-Party Services</h2>
  <p>Our systems may integrate with third-party platforms (e.g., Facebook Login) for authentication purposes. These services may collect data in accordance with their own privacy policies.</p>
  <br><br>
  -->
  <h2 class="header header-smallish">Contact</h2>
  <p>If you have any questions about this policy, please contact us at <a href="mailto:data@bulsca.co.uk">data@bulsca.co.uk</a>.</p>
</div>


</div>
@endsection
