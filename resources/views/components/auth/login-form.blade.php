
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-height-300 m-3 border-radius-xl" style="background-image: url('https://images.unsplash.com/photo-1491466424936-e304919aada7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1949&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
    </div>
    <div class="container mb-4">
      <div class="row mt-lg-n12 mt-md-n12 mt-n12 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card mt-8">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1 text-center py-4">
                <h4 class="font-weight-bolder text-white mt-1">Sign In</h4>
                <p class="mb-1 text-sm text-white">Enter your email and password to Sign In</p>
              </div>
            </div>
            <div class="card-body">
              <form role="form" class="text-start">
                <div class="input-group-static mb-4">
                  <label class="text-bold">E-mail</label>
                  <input id="email" type="email" class="form-control" placeholder="">
                </div>
                <div class="input-group-static mb-4">
                  <label class="text-bold">Password</label>
                  <input id="password" type="password" class="form-control" placeholder="">
                </div>
                <div class="form-check form-switch d-flex align-items-right mb-3 ms-5">
                    <a href="{{ url('/send-otp') }}" target="_blank">Forgot Password ?</a>
                </div>
                <div class="text-center">
                  <button onclick="SubmitLogin()" type="button" class="btn bg-gradient-dark w-100 mt-3 mb-0">Sign in</button>
                </div>
              </form>
            </div>
            <div class="card-footer text-center pt-0 px-lg-2 px-1">
              <p class="mb-4 text-sm mx-auto">
                Don't have an account?
                <a href="{{ url('/User-Registration') }}" class="text-success text-gradient font-weight-bold">Sign up</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="container" style="margin-left: 60rem;">
    <div class="col-sm-4 login-container bg-light">
        <h2 class="text-bold text-center mb-4">Guest Login</h2>
        <form>
            <div class="form-group">
                <label for="username" class="text-bold">Use User Name:</label>
                <input type="text" id="username" class="form-control" value="admin@gmail.com" readonly>
            </div>
            <div class="form-group">
                <label for="password" class="text-bold">Use Password:</label>
                <input type="text" id="password" class="form-control" value="admin" readonly>
            </div>
        </form>
    </div>
</div>

<script>

    async function SubmitLogin(){

        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        if (email.length===0){
            alert('Email is required');
        }
        else if(password.length===0){
            alert('Password is required');
        }
        else
        {
            let res = await axios.post("/user-login", {email:email, password:password});
            if(res.status === 200 && res.data['status']==='success'){
                window.location.href="/sales-summary";
            }
            else
            {
                alert('user email or password incorrect');
            }
        }

    }

</script>
