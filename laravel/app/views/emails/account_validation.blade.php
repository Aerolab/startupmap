@extends('emails.layout')
@section('outlet')
<h2 style="margin:0 0 14px;line-height:1;">Hola {{ $name }}</h2>
<p style="font-size:15px;line-height:1.5;">
	Gracias por registrarte en StartupMap! Ahora solo falta validar tu cuenta y ya podras publicar tu startup en nuestro mapa, para hacerlo simplemente sigue en enlace debajo:
</p>
{{ link_to_route('user.validate', 'Valida tu cuenta', array( 'key' => $userKey ), array('style' => 'display:inline-block;padding:10px 13px;border-radius:3px;background:#5BB141;text-decoration:none;font-weight:bold;color:white;')) }}
<a href="{{ route('user.validate', array( 'key' => $userKey )) }}" style="font-size:12px;font-style:italic;color:#999;display:block;margin:15px 0 0;text-decoration:none;">{{ route('user.validate', array('key' => $userKey)) }}</a>
@endsection