@if(count($unread) > 0)
@foreach($unread as $u)
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<h4><i class="icon fa fa-info"></i> {{ ucwords($u->title) }}</h4>
	<p>{{ ucwords($u->message) }}</p>
	<p><a href="{{ route($u->url) }}">Link to view</a></p>
</div>
@endforeach
@endif