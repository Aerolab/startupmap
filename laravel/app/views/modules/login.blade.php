<div id="login" class="sidebarPanel scrollable">
    <h2>Bienvenido a Startup<span>Map</span>!</h2>
    <p>
        Queremos ayudar a visibilizar y conectar al ecosistema emprendedor en Argentina y la región.<br/>
        América Latina está creciendo con fuerza y creemos que merece mostrarse orgullosa y mostrarle
        al mundo lo que sus emprendedores tienen para ofrecer.
    </p>
    <form action="#">
        <fieldset>
            <legend>Login</legend>
            <div class="control with-icon" data-control="login-email">
                <i class="fa fa-envelope"></i>
                {{ Form::text('email', Input::get('email'), array( 'id' => 'appLoginEmail', 'placeholder' => 'Correo electronico' )) }}
                <ul class="errorList"></ul>
            </div>
            <div class="control with-icon" data-control="login-password">
                <i class="fa fa-key"></i>
                {{ Form::password('password', array( 'id' => 'appLoginPassword', 'placeholder' => 'Contraseña' )) }}
                <ul class="errorList"></ul>
                <a href="#" id="recoverBtn">Olvidaste tu contraseña?</a>
            </div>
            <button type="button" class="app btn login" id="btnLogin" data-app-route="auth.login">
                <span class="normal"><i class="fa fa-check"></i> Login</span>
                <span class="processing"><i class="fa fa-spinner fa-spin"></i></span>
            </button>
        </fieldset>
        <div class="separator">
            <span>o</span>
        </div>
        <a href="#" class="btn linkedin app" data-app-route="auth.linkedin">
            <span class="normal"><i class="fa fa-linkedin-square"></i> Ingresar con LinkedIn</span>
            <span class="processing"><i class="fa fa-spinner fa-spin"></i></a>
        </a>
        <a href="#" id="registerBtn">Es tu primera vez? <span>Registrate</span></a>
    </form>
</div>
<!-- END #login -->