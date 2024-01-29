
  <main class="main-content main-content-bg mt-0">
    <div class="page-header align-items-start min-height-300 m-3 border-radius-xl bg-gray-200" style="background-image: url('https://images.unsplash.com/photo-1545569341-9eb8b30979d9?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80'); background-size: cover; background-position:center;">
      <span class="mask bg-gradient-dark opacity-4"></span>
    </div>
    <div class="container">
      <div class="row mt-lg-n12 mt-md-n12 mt-n11 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card mt-8">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1 text-center py-4">
                <h4 class="font-weight-bolder text-white mt-1">Join us today</h4>
                <p class="mb-1 text-white text-sm">Enter your information to register</p>
              </div>
            </div>
            <div class="card-body pb-3">
            <form role="form" action="" method="post">
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">First Name</label>
                  <input id="first_name" type="text" class="form-control">
                </div>
                  <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Last Name</label>
                  <input id="last_name" type="text" class="form-control">
                </div>
                  <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Phone Number</label>
                  <input id="phone" type="text" class="form-control">
                </div>
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Email</label>
                  <input id="email" type="email" class="form-control">
                </div>
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Password</label>
                  <input id="password" type="password" class="form-control">
                </div>
                <div class="form-check text-left">
                  <input class="form-check-input bg-dark border-dark" type="checkbox" value="" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree the <a href="{{ asset('pages/privacy.html') }}" class="text-dark font-weight-bolder">Terms and Conditions</a>
                  </label>
                </div>
                <div class="text-center">
                  <button onclick="OnRegistration()" type="button" class="btn bg-gradient-primary w-100 mt-4 mb-0">Sign up</button>
                </div>
              </form>
            </div>
            <div class="card-footer text-center pt-0 px-sm-4 px-1">
              <p class="mb-4 mx-auto">
                Already have an account?
                <a href="{{ url('/login') }}" class="text-primary text-gradient font-weight-bold">Sign in</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<script>

    async function OnRegistration(){
        let first_name = document.getElementById('first_name').value;
        let last_name = document.getElementById('last_name').value;
        let phone = document.getElementById('phone').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        if(!first_name || !last_name || !phone || !email || password.length === 0){
            alert('Please fillup all fields');
        }
        else
        {
            let res = await axios.post('/user-registration',
            {
                first_name:first_name,
                last_name:last_name,
                phone:phone,
                email:email,
                password:password
            });
            if(res.status === 200 && res.data['status'] === 'success')
            {
                // alert('Registration successful');
                setTimeout(function(){
                    window.location.href='/';
                },2000)
            }
            else
            {
                alert('Registration failed');
                // console.log(res);
            }
        }
    }
</script>
