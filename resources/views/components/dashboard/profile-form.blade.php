<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4 class="text-primary">User Profile</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label class="h6">Email Address</label>
                                <input readonly id="email" placeholder="" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label class="h6">First Name</label>
                                <input id="first_name" placeholder="" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label class="h6">Last Name</label>
                                <input id="last_name" placeholder="" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label class="h6">Mobile Number</label>
                                <input id="phone" placeholder="" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label class="h6">Password</label>
                                <input id="password" placeholder="" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

        getprofile();
    async function getprofile(){

        let res = await axios.get('/user-profile');

        if (res.status===200 && res.data['status'] === 'success'){
            let data = res.data['data'];
            document.getElementById('email').value = data['email'];
            document.getElementById('first_name').value = data['first_name'];
            document.getElementById('last_name').value = data['last_name'];
            document.getElementById('phone').value = data['phone'];
            document.getElementById('password').value = data['password'];
        }
        else {
                alert('something went wrong');
               // return console.log(res);
        }
    }

    async function onUpdate(){
        let first_name = document.getElementById('first_name').value;
        let last_name = document.getElementById('last_name').value;
        let phone = document.getElementById('phone').value;
        let password = document.getElementById('password').value;

        if(!first_name || !last_name || !phone || password.length === 0){
            alert('Please fillup all fields');
        }
        else
        {
            let res = await axios.post('/profile-update',
            {
                first_name:first_name,
                last_name:last_name,
                phone:phone,
                password:password
            })
            if(res.status === 200 && res.data['status'] === 'success')
            {
                alert('profile update successful');
                await getprofile();
            }
            else
            {
                alert('Update failed');
            }
        }
    }

</script>
