<div id="big-div">
    <div class="container text-center rounded w-50">
        <div class="row">

            <div class="col-md-6 col-lg-5 border border-5 border-dark container small-div">
                <h1>ADMIN LOGIN</h1>
                <p class="text-start">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Libero possimus doloremque cupiditate temporibus doloribus </p>
            </div>

            <div class="col-md-6 col-lg-7 border border-5 border-dark container small-div-2">
                 <!-- send to /login/check-admin on routes.php -->
                <form action="/login/check-admin" method="POST">

                    <h3>Gift Control</h3>

                    <div class="container">

                        <h4>Please login to your admin account</h4>

                        <!-- Error message display -->
                        <?php if (!empty($message)): ?>
                          <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($message) ?>
                          </div>
                        <?php endif; ?>

                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" name="username" placeholder="Enter name" id="username-input" value="Bob">
                            <label for="username-input">Username</label>
                        </div>

                        <div class="form-floating mb-3 mt-3">
                            <input type="password" class="form-control" name="password" placeholder="Enter password" id="password-input" value="securePass">
                            <label for="password-input">Password</label>
                        </div>

                        <button class="btn btn-primary button-1">Log in</button>
                        
                    </div>

                    <a href="#">Forgot password?</a>

                    <div class="container">
                        <a href="#">Don t have an account?</a>
                        <button class="btn btn-outline-success">Create New</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
