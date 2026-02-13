<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="en" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="en" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="en">
<!--<![endif]-->

<!-- begin head -->
<?php echo view("head"); ?>
<!-- end head -->

<body>

    <!-- begin head -->
    <?php echo view("header"); ?>
    <!-- end head -->

    <div id="account-login" class="container acpage">
        <div class="row">
            <div id="content" class="col-sm-12 col-md-6 col-lg-6 col-xs-12 colright">
                <div class="head-t mt60 mb20 text-center">
                    <h4 class="heading font-size3_5">
                    </h4>
                </div>

                <div class="row afflog container-card">
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xs-12">
                        <div class="well bg-card">
                            <!-- Bienvenido -->
                            <h1 class="text-center title"
                                style="font-size: 20px; color: black !important; font-weight: bold;">
                                <?php echo lang('Global.bienvenido'); ?></h1>
                            <form name="form-login" action="javascript:void(0);" onsubmit="login();"
                                class="wpcf7-form init" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <!-- usuario -->
                                    <label class="control-label fs14"
                                        for="input-email"><?php echo lang('Global.usuario'); ?></label>
                                    <input type="hidden" name="type_login" id="type_login" value="1">
                                    <input type="text" placeholder="Ingrese usuario" name="username" autocomplete="off"
                                        class="form-control bg-transparent" autofocus required
                                        style="background-color: white !important;" />
                                </div>
                                <div class="form-group">
                                    <!-- contrasena -->
                                    <label class="control-label fs14"
                                        for="input-password"><?php echo lang('Global.contrasena'); ?></label>
                                    <input type="password" placeholder="Ingrese contraseña" name="password"
                                        autocomplete="off" class="form-control bg-transparent" required
                                        style="background-color: white !important;" />
                                    <div class="text-right">
                                        <a class="btn-custom-linked"
                                            href="<?php echo site_url() . "forget-password"; ?>"><?php echo lang('Global.recuperar_contrasena'); ?></a>
                                    </div>
                                </div>
                                <div class="container-btn">
                                    <button type="submit" id="submit" class="btn btn-primary btn-custom">Iniciar
                                        Sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="content" class="col-sm-12 col-md-6 col-lg-6 col-xs-12 colright">
                <div class="head-t mt60 mb20 text-center">
                    <h4 class="heading font-size3_5">
                    </h4>
                </div>
                <div class="row afflog container-card">
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xs-12">
                        <div class="well bg-card">
                            <h1 class="text-center title"
                                style="font-size: 20px; color: black !important; font-weight: bold;">Nuevo Socio</h1>
                            <form name="form-new_registro" action="javascript:void(0);" onsubmit="new_registro();"
                                class="wpcf7-form init" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-email">Usuario</label>
                                    <input type="hidden" name="type_register" id="type_register" value="1">
                                    <input type="text" placeholder="Ingrese Usuario" name="username" id="username"
                                        autocomplete="off" onkeyup="this.value=Numtext(this.value)"
                                        onblur="validate_username(this.value);" class="form-control bg-transparent"
                                        minlength="8" onkeyup="javascript:this.value=this.value.toLowerCase();"
                                        autofocus required />
                                    <div class="alert-0"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-password">Contraseña</label>
                                    <input type="password" placeholder="Ingrese Contraseña" minlength="5"
                                        name="password" id="password" autocomplete="off"
                                        class="form-control bg-transparent" required
                                        style="background-color: white !important;" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-password">Confirmar contraseña</label>
                                    <input type="password" placeholder="Confirme Contraseña" minlength="5"
                                        name="confirm_password" id="confirm_password" onkeyup="validate_pass()"
                                        autocomplete="off" class="form-control bg-transparent" required
                                        style="background-color: white !important;" />
                                    <div class="alert-1"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-password">Nombre</label>
                                    <input type="text" placeholder="Ingrese Nombre" name="name" autocomplete="off"
                                        class="form-control bg-transparent" required
                                        style="background-color: white !important;" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-password">Apellidos</label>
                                    <input type="text" placeholder="Ingrese Apellido" name="lastname" autocomplete="off"
                                        class="form-control bg-transparent" required
                                        style="background-color: white !important;" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-password">DNI</label>
                                    <input type="text" placeholder="Ingrese DNI" name="dni" autocomplete="off"
                                        class="form-control bg" minlength="8" maxlength="8" required
                                        style="background-color: white !important;" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-password">Correo Electrónico</label>
                                    <input type="email" placeholder="Ingrese Email" name="email" autocomplete="off"
                                        class="form-control" required style="background-color: white !important;" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-password">Teléfono</label>
                                    <input type="text" placeholder="Ingrese teléfono" name="phone" autocomplete="off"
                                        class="form-control" required style="background-color: white !important;" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label fs14" for="input-password">País</label>
                                    <select name="country_id" id="country_id" class="form-control" required
                                        style="background-color: white !important;">
                                        <option value="">Seleccionar País...</option>
                                        <?php foreach ($obj_paises as $value) : ?>
                                        <option value="<?php echo $value->id; ?>">
                                            <?php echo $value->nombre; ?> (<?php echo "+" . $value->id_wsp; ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="container-btn">
                                    <button type="submit" id="submit"
                                        class="btn btn-primary btn-custom">Registrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- begin footer -->
    <?php echo view("footer"); ?>
    <!-- end footer -->

    <script src='<?php echo site_url() . 'assets/front/js/script/login.js?20232'; ?>'></script>
    <script src='<?php echo site_url() . 'assets/js/script/new_registro.js?20232'; ?>'></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LdZLOQpAAAAAMU782Tpmk-fpXORtHgnoRM0_Ak8"></script>

</body>

</html>