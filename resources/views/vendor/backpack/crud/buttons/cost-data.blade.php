@if ($crud->hasAccess('cost-data'))
<div class="card-body" style="padding: 4px;">
    <a href="javascript:void(0)" onclick='wpcCosts()' class="btn btn-primary"><i class="la la-dollar"></i>View Costs</a>
</div>
@endif