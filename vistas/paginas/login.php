<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/css/plugins/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
	  <div class="login-logo">
	    <p><strong>Iniciar Sesión</strong></p>
	  </div>
	  <!-- /.login-logo -->
	  <div class="card">
	    <div class="card-body login-card-body m-2">
	      <p class="login-box-msg">Ingrese usuario y contraseña</p>

	      <form id="formInciarSesion" method="POST">
	      	<input type="hidden" name="funcion" value="inciarSesion">
	        <div class="input-group mb-3">
	          <input type="text" class="form-control" placeholder="Usuario" name="txtUser">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-envelope"></span>
	            </div>
	          </div>
	        </div>
	        <div class="input-group mb-3">
	          <input type="password" class="form-control" placeholder="Contraseña" name="txtContra">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-lock"></span>
	            </div>
	          </div>
	        </div>
	        <div class="row">
	        		<input type="submit" class="btn btn-primary btn-block" value="Continuar">
	            <!-- 

	            <button type="submit" class="btn btn-primary btn-block">Continuar</button>
	             -->
	        </div>
	      </form>
	    </div>
	    <!-- /.login-card-body -->
	  </div>
	</div>
<!-- /.login-box -->

<!-- jQuery -->
	<script src="vistas/js/plugins/jquery.js"></script>
	<!-- Sweetalert2 -->
<script type="text/javascript" src="vistas/js/plugins/sweetalert2.all.js"></script>

	<script type="text/javascript" src="vistas/js/funciones.js"></script>

<script type="text/javascript" src="vistas/js/login.js"></script>

<!-- AdminLTE App
<script src="vistas/js/plugins/adminlte.min.js"></script>
 -->
</body>