<head>
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <div class="toast-container position-fixed top-0 end-0">
    <div id="liveToast" class="toast bg-danger rounded w-100" role="alert" aria-live="assertive" aria-atomic="true" 
      data-autohide="true" data-delay="5000" data-animation="true">
      <div class="toast-header">
        <i class="bi-x-square"></i>
        <strong class="me-auto ms-3">Error</strong>
        <button type="button" class="btn-close" aria-label="Close" data-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        Usuario o contraseña incorrecta
      </div>
    </div>
  </div>

  <div class="container-fluid h-100 gradient-form">
    <div class="row d-flex justify-content-center align-items-center h-100 mx-0">
      <div class="col-lg-10 col-sm-12 col-md-8">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="../assets/logo-tiny.png" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Grupo Corsan</h4>
                </div>
                <form>
                  <span>Por favor inicia sesión</span>
                  <div class="form-group">
                    <input type="text" id="userName" class="form-control" placeholder="Usuario o Email" />
                    <label class="form-label" for="userName">Usuario</label>
                  </div>

                  <div class="form-group">
                    <input type="password" id="password" class="form-control" placeholder="Contraseña"/>
                    <label class="form-label" for="password">Contraseña</label>
                  </div>

                  <div class="text-center">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" id="btnLogin">Ingresar</button>
                  </div>

                  <div class="text-center">
                    <a class="text-muted" href="#!">Olvidaste tu contraseña?</a>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2 d-none d-lg-inline-block">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">We are more than just a company</h4>
                <p class="small mb-0 justify">Interglobal Insurance Company, an independent insurance agency located in Homestead, FL
                  specializing in trucking and commercial auto insurance is committed to the principles of service,
                  integrity and professionalism while providing our valued clients the highest quality of service with
                  the goal of exceeding their expectations. Financial security and protection for our clients’ commitment
                  as well as fairness and empowerment to our agents . Respect and opportunity for our employees,
                  increasing value and reward.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<script>
  $(document).ready(function() {

    $('#btnLogin').click(function(event) {
      event.preventDefault();
      login();
    });

    function login() {
      $user = $("#userName").val();
      $pass = $("#password").val();
      $.post("../controllers/Login.php", {
          user: $user,
          pass: $pass,
          action: 'login'
        })
        .done(function(resp) {
          resp = JSON.parse(resp);
          console.log(resp);
          if (resp) {
            $("#allContent").load("main.php");
          } else {
            $('#liveToast').toast('show');
          }
        });
    }
  });
</script>