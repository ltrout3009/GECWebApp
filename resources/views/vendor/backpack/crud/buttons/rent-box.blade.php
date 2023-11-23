<!--
<a href="{{ url($crud->route.'/'.$entry->getKey().'/rentBox') }}" class="btn btn-xs btn-primary"><i class="la la-dumpster" style="padding: 0px 5px 0px 0px; font-size: 18px;"></i>Rent Box</a>
-->

<a href="{{ url('admin/rental-asset-transaction/create/?code='.$entry->getKey()) }}" class="btn btn-xs btn-primary"><i class="la la-dumpster" style="padding: 0px 5px 0px 0px; font-size: 18px;"></i>Rent Box</a>