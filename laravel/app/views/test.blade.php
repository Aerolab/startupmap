{{ Form::open(array('route' => 'api.user.store')) }}
    {{ Form::text('name', Input::get('name'), array( 'placeholder' => 'Nombre' )) }}
    {{ Form::text('last_name', Input::get('last_name'), array( 'placeholder' => 'Apellido' )) }}
    {{ Form::text('email', Input::get('email'), array( 'placeholder' => 'Correo electronico' )) }}
    {{ Form::password('password', array( 'placeholder' => 'Contraseña' )) }}
    {{ Form::submit() }}
{{ Form::close() }}