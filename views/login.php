<head>
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <div id="liveToast" class="fixed top-0 left-1/2 transform -translate-x-1/2 hidden mt-6 w-64 bg-red-700 rounded">
    <div class="rounded w-full p-2" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="text-white mt-1 ms-1 text-sm">
        <strong class="">Error</strong>
      </div>
      <div class="text-white text-center">
        Incorrect username or password
      </div>
    </div>
  </div>

  <div class="h-view flex items-center justify-center w-5/6 mx-auto">
    <div class="w-full lg:w-5/6 flex flex-row">
      <div class="w-full md:w-1/2 bg-white px-5 py-3 text-sky-950">
        <div class="flex flex-col items-center">
          <img src="../assets/logo-tiny.png" alt="logo">
          <h4 class="text-2xl font-bold">Grupo Corsan</h4>
        </div>
        <form>
          <span>Please Log In to continue</span>
          <div class="flex flex-col mt-2">
            <label class="form-label" for="userName">Username</label>
            <input type="text" id="userName" class="border-gray-400 rounded border px-3 py-4 cursor-pointer hover:border-2" placeholder="Usuario o Email" />
          </div>

          <div class="flex flex-col">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" class="border-gray-400 rounded border px-3 py-4 cursor-pointer hover:border-2" placeholder="Contraseña" />
          </div>

          <div class="text-center mt-4">
            <button class="bg-gradient-to-r from-sky-700 to-sky-950 shadow-sky-950/30 hover:border-sky-800 transition-all duration-500 ease-in-out" type="submit" id="btnLogin">Log In</button>
          </div>

          <div class="text-center">
            <a class="text-muted" href="#!">Forgot your Password?</a>
          </div>

        </form>
      </div>
      <div class="w-1/2 text-center gradient-custom-2 hidden md:flex items-center">
        <div class="text-white px-4">
          <h4 class="text-3xl font-bold">We are more than just a company</h4>
          <p class="text-justify mt-3 text-lg">Interglobal Insurance Company, an independent insurance agency located in Homestead, FL
            specializing in trucking and commercial auto insurance is committed to the principles of service,
            integrity and professionalism while providing our valued clients the highest quality of service with
            the goal of exceeding their expectations. Financial security and protection for our clients’ commitment
            as well as fairness and empowerment to our agents . Respect and opportunity for our employees,
            increasing value and reward.</p>
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
            modalShow('liveToast');
            setTimeout(function () {
                modalHide('liveToast');
            }, 3000);
          }
        });
    }
  });
</script>