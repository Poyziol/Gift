<div id="big-div">
    <div class="container text-center rounded w-50">
        <div class="row">

            <div class="col-md-6 col-lg-5 border border-5 border-dark container small-div">
                <h1>USER LOGIN</h1>
                <p class="text-start">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Libero possimus doloremque cupiditate temporibus doloribus </p>
            </div>

            <div class="col-md-6 col-lg-7 border border-5 border-dark container small-div-2">
                <!-- send to /login/check-user on routes.php -->
                <form action="/login/check-user" method="POST">

                    <h3>Gift Control</h3>

                    <div class="container">

                        <h4>Please login to your account</h4>

                        <!-- Error message display -->
                        <?php if (!empty($message)): ?>
                          <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($message) ?>
                          </div>
                        <?php endif; ?>

                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" name="username" placeholder="Enter name" id="username-input" value="Charlie">
                            <label for="username-input">Username</label>
                        </div>

                        <div class="form-floating mb-3 mt-3">
                            <input type="password" class="form-control" name="password" placeholder="Enter password" id="password-input" value="mypassword">
                            <label for="password-input">Password</label>
                        </div>

                        <button class="btn btn-primary button-1">Log in</button>
                        
                    </div>

                </form>

                    <a href="#">Forgot password?</a>

                    <div class="container">
                        <a href="#">Don t have an account?</a>
                        <!-- Changed the button to a link to make easy redirection -->
                        <a class="btn btn-outline-success" href="/login/admin">Create New</a>
                    </div>

            </div>

        </div>
    </div>
</div>
