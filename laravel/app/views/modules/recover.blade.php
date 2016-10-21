<div id="recover" class="sidebarPanel scrollable">
    <div class="success">
        <div class="icon">
            <span class="fa-stack fa-lg">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-thumbs-o-up fa-stack-1x"></i>
            </span>
        </div>
        <p><h3>¡Enhorabuena!</h3></p>
        <p>Acabamos de enviarte un e-mail con instrucciones para recuperar tu cuenta.</p>
    </div>

    <h2>Recupera tu contraseña?</h2>
    <form action="#" id="recoverForm">
        <fieldset class="borderless">
            <div class="control with-icon" data-control="recover-email">
                <i class="fa fa-envelope"></i>
                {{ Form::text('email', Input::get('email'), array( 'placeholder' => 'Correo electronico' )) }}
                <ul class="errorList"></ul>
            </div>
            <button type="button" class="app btn recover" id="btnRecover" data-app-route="user.recover">
                <span class="normal"><i class="fa fa-arrow-right"></i> Recupera tu cuenta</span>
                <span class="processing"><i class="fa fa-spinner fa-spin"></i></span>
            </button>
        </fieldset>
        <a href="#" id="recoverBackBtn">Iniciar sesión</a>
    </form>
</div>
<!-- END #register -->