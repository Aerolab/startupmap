@extends('emails.layout')
@section('outlet')
<h2 style="margin:0 0 14px;line-height:1;">Hola {{ $name }}</h2>
<p style="font-size:15px;line-height:1.5;">
	Estamos contentos de informarte que tu peticion para ser listado como founder de {{ $startup }} ha sido <b>aceptada</b>.<br/>
</p>
{{ link_to_route('root', 'Ir a StartupMap', array(), array('style' => 'display:inline-block;padding:10px 13px;border-radius:3px;background:#5BB141;text-decoration:none;font-weight:bold;color:white;')) }}
<a href="{{ route('root') }}" style="font-size:12px;font-style:italic;color:#999;display:block;margin:15px 0 0;text-decoration:none;">{{ route('root') }}</a>
@endsection