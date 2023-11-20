<link rel="stylesheet" href="/app.css">

<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<div class="row">
		<div class="col">
            <h3 class="text-decoration-underline">Mailing Address</h3>
			<strong>Address: </strong> {{ $entry->mailing_address }} <br>
            <strong>Address 2: </strong> {{ $entry->mailing_address_2 }} <br>
            <strong>City: </strong> {{ $entry->mailing_city}} <br>
            <strong>State: </strong> {{ $entry->mailing_state}} <br>
            <strong>Zip: </strong> {{ $entry->mailing_zip}} <br>
		</div>
        <div class="col">
            <h3 class="text-decoration-underline">Site Address</h3>
			<strong>Address: </strong> {{ $entry->site_address }} <br>
            <strong>Address 2: </strong> {{ $entry->site_address_2 }} <br>
            <strong>City: </strong> {{ $entry->site_city}} <br>
            <strong>State: </strong> {{ $entry->site_state}} <br>
            <strong>Zip: </strong> {{ $entry->site_zip}} <br>
		</div>
        <div class="col">
            <h3 class="text-decoration-underline">Account Assignments</h3>
			<strong>Sales: </strong> {{ 'TEST Sales' }} <br>
            <strong>CSR: </strong> {{ 'TEST CSR' }} <br>
            <strong>TFS: </strong> {{ 'TEST TFS' }} <br>
            <strong>CFS: </strong> {{ 'TEST CFS' }} <br>
		</div>
        <div class="col">
            <h3 class="text-decoration-underline">Billing Information</h3>
			<strong>Bill To: </strong> {{ 'TEST Bill To Name' }} <br>
		</div>
        <!-- Proof of Concept to list Profile Names-->
<!--
        <div class="col">
            <h3 class="text-decoration-underline">Profiles</h3>
			@foreach ( $entry->profiles as $profile )
                {{ $profile->name }} <br>
            @endforeach <br>
		</div>
-->
	</div>
</div>
<div class="clearfix"></div>