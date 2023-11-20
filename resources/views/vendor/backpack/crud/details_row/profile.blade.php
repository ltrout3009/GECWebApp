<link rel="stylesheet" href="/app.css">

<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<div class="row">
		<div class="col">
            <h3 class="text-decoration-underline">Profile Info</h3>
                <strong>Description: </strong> {{ $entry->description }} <br>
                <strong>State Waste Code: </strong> {{ $entry->state_waste_code_num }} <br>
                <strong>Hazardous Waste: </strong> 
                    @if($entry->is_hazardous_waste == '0') <span class="badge rounded-pill bg-info">{{ $entry->is_hazardous_waste ? 'Yes' : 'No' }}</span> <br> 
                    @elseif($entry->is_hazardous_waste == '1') <span class="badge rounded-pill bg-warning">{{ $entry->is_hazardous_waste ? 'Yes' : 'No' }}</span> <br> 
                    @endif
                <strong>Federal Universal Waste: </strong> 
                    @if($entry->is_fed_universal_waste == '0') <span class="badge rounded-pill bg-info">{{ $entry->is_fed_universal_waste ? 'Yes' : 'No' }}</span> <br> 
                    @elseif($entry->is_fed_universal_waste == '1') <span class="badge rounded-pill bg-warning">{{ $entry->is_fed_universal_waste ? 'Yes' : 'No' }}</span> <br> 
                    @endif
                <strong>State Universal Waste: </strong> 
                    @if($entry->is_state_universal_waste == '0') <span class="badge rounded-pill bg-info">{{ $entry->is_state_universal_waste ? 'Yes' : 'No' }}</span> <br> 
                    @elseif($entry->is_state_universal_waste == '1') <span class="badge rounded-pill bg-warning">{{ $entry->is_state_universal_waste ? 'Yes' : 'No' }}</span> <br> 
                    @endif
		</div>

        <div class="col">
            <h3 class="text-decoration-underline">Approval Info</h3>
                @foreach ($entry->approvals as $approval)
                <strong>Disposal Facility: </strong>
                    <a href="approval/{{$approval->id}}/show"> {{ $approval->facility->name ?? 'No Approval Facilities'}} </a>
                    @if($approval->approval_status == 'Approved') <span class="badge rounded-pill bg-success">{{ $approval->approval_status }}</span>
                        @elseif($approval->approval_status == 'Expired') <span class="badge rounded-pill bg-danger">{{ $approval->approval_status }}</span>
                        @elseif($approval->approval_status == 'Cancelled') <span class="badge rounded-pill bg-warning">{{ $approval->approval_status }}</span>         
                        @else <span class="badge rounded-pill bg-info">{{ $approval->approval_status }}</span>
                    @endif
                    @if($approval->is_primary_facility == '1') <span class="badge rounded-pill bg-success">{{ $approval->is_primary_facility ? 'Primary' : 'Not Primary' }}</span>    
                        @else <span class="badge rounded-pill bg-warning">{{ $approval->is_primary_facility ? 'Primary' : 'Not Primary' }}</span>
                    @endif
                    <br>
                @endforeach
		</div>
	</div>
</div>
<div class="clearfix"></div>


