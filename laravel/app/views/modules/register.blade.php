<div id="register" class="sidebarPanel scrollable">
    <div class="success" id="registerSuccess">
        <div class="icon">
            <span class="fa-stack fa-lg">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-thumbs-o-up fa-stack-1x"></i>
            </span>
        </div>
        <p><h3>¡Bienvenido!</h3></p>
        <p>Tu cuenta fue creada y te enviamos un e-mail de validaci&oacute; a tu casilla.</p>
    </div>

    <h2>Registrate y ayudanos</h2>
    <p>
        Ayudanos a mapear el dinámico mundo startup. Colaborá sumando tu organización o ayudanos también a completar la información de otras.
    </p>
    <form action="#" id="registerForm">
        <fieldset>
            <legend>Registrate</legend>
            <div class="control with-icon" data-control="register-name">
                <i class="fa fa-user"></i>
                {{ Form::text('name', Input::get('name'), array( 'placeholder' => 'Nombre' )) }}
                <ul class="errorList"></ul>
            </div>
            <div class="control" data-control="register-last_name">
                {{ Form::text('last_name', Input::get('last_name'), array( 'placeholder' => 'Apellido' )) }}
                <ul class="errorList"></ul>
            </div>
            <div class="control with-icon" data-control="register-email">
                <i class="fa fa-envelope"></i>
                {{ Form::text('email', Input::get('email'), array( 'placeholder' => 'Correo electronico' )) }}
                <ul class="errorList"></ul>
            </div>
            <div class="control with-icon" data-control="register-password">
                <i class="fa fa-key"></i>
                {{ Form::password('password', array( 'placeholder' => 'Contraseña' )) }}
                <ul class="errorList"></ul>
            </div>
            <button type="button" class="app btn login" id="btnRegister" data-app-route="user.create">
                <span class="normal"><i class="fa fa-arrow-right"></i> Crear una cuenta</span>
                <span class="processing"><i class="fa fa-spinner fa-spin"></i></span>
            </button>
        </fieldset>
        <div class="separator">
            <span>o</span>
        </div>
        <a href="#" class="btn linkedin app" data-app-route="auth.linkedin"><i class="fa fa-linkedin-square"></i> Ingresar con LinkedIn</a>
        <a href="#" id="registerBackBtn">Iniciar sesión</a>
    </form>
</div>
<!-- END #register -->