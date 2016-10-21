@extends('emails.layout')
@section('outlet')
<h2 style="margin:0 0 14px;line-height:1;">Hola {{ $name }}</h2>
<p style="font-size:15px;line-height:1.5;">
	Empezaste el proceso para recuperar tu contrase&ntilde;a en StartupMap, para continuarlo simplemente sigue en enlace debajo (si no hiciste eso, simplemente ignora este correo)
</p>
{{ link_to_route('reset_password', 'Recupera tu contrase&ntilde;a', array('token' => $token), array('style' => 'display:inline-block;padding:10px 13px;border-radius:3px;background:#5BB141;text-decoration:none;font-weight:bold;color:white;')) }}
<a href="{{ route('reset_password', array('token' => $token)) }}" style="font-size:12px;font-style:italic;color:#999;display:block;margin:15px 0 0;text-decoration:none;">{{ route('reset_password', array('token' => $token)) }}</a>
@endsection