<div class="mt-auto container-fluid">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">WPC</th>
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
            @foreach ($entry->wastes as $waste)
                <tr>
                    <td> {{ $entry->id }} </td>
                    <td> {{ $waste->facility->name }} </td>
                    <td> {{ $waste->vendor_code }} </td>
                    <td> {{ $waste->container->category }} </td>
                    <td> {{ $waste->container->size}} </td>
                    <td> {{ $waste->base->name }} </td>
                    <td> {{ $waste->cost }} </td>
                    <td> {{ $waste->min_cost }} </td>
                    <td> {{ $waste->is_case_by_case }} </td>
                    <td> {{ $waste->is_enterprise }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="clearfix"></div>