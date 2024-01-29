
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
                <h4 class="font-weight-bolder text-white mt-1">Reset Your Password</h4>
              </div>
            </div>
            <div class="card-body">
              <form role="form" class="text-start">
                <div class="input-group input-group-static mb-4">
                  <label>Enter New Password</label>
                  <input id="password" type="password" class="form-control" placeholder="•••••••••••••">
                </div>
                <div class="input-group input-group-static mb-4">
                    <label>Confirm New Password</label>
                    <input id="cpassword" type="password" class="form-control" placeholder="•••••••••••••">
                  </div>
                <div class="text-center">
                  <button onclick="resetpassword()" type="button" class="btn bg-gradient-dark w-100 mt-3 mb-0">Reset Password</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    async function resetpassword() {
          let password = document.getElementById('password').value;
          let cpassword = document.getElementById('cpassword').value;
          if(password.length===0){
            alert('Password is required');
          }
          else if(cpassword.length===0){
            alert('Confirm Password is required');
          }
          else if(password!==cpassword){
            alert('Password and Confirm Password must be same');
          }
          else{
            let res=await axios.post("/Set-Password",{password:password});
            if(res.status===200 && res.data['status']==='success'){
                alert('Rassword changed successfully');
                setTimeout(function () {
                    window.location.href="/login";
                },1000);
            }
            else{
              alert('Password changed failed');
            }
          }
      }
  </script>
