<link rel="stylesheet" href="/app.css">

<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<table class="table">
        <thead>
            <tr>
                <th scope="col">TSDF</th>
                <th scope="col">Vendor Code</th>
                <th scope="col">Container Type</th>
                <th scope="col">Container Size</th>
                <th scope="col">Cost Basis</th>
                <th scope="col">Cost</th>
                <th scope="col">Min Cost</th>
                <th scope="col">Case By Case</th>
                <th scope="col">Enterprise</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($entry->facility as $facil)
            <tr>
                <td>{{ $entry->facility->name }}</td>
                <td>{{ $entry->vendor_code }}</td>
                <td>{{ $entry->container->category }}</td>
                <td>{{ $entry->container->size }}</td>
                <td>{{ $entry->base->name }}</td>
                <td>{{ $entry->cost }}</td>
                <td>{{ $entry->min_cost }}</td>
                <td>{{ $entry->is_case_by_case }}</td>
                <td>{{ $entry->is_enterprise }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="clearfix"></div>


