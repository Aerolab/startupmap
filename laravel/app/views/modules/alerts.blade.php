@if($errors->count() != 0)
<div class="alert alert-error">
	@foreach($errors->all('<p>:message</p>') as $error)
	{{ $error }}
	@endforeach
</div>
@endif

@if(isset($message))
<p class="alert alert-info">
	{{ $message }}
</p>
@endif