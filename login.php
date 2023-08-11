<?php

require_once __DIR__ . "/partials/menu.php";


?>

<div class="container">
    <div class="row">
        <div class="col-8 offset-2 mt-5 ">
            <form class="p-5 mt-5" method="POST" action="adminLogin.php">
            <div class="form-group">
                    <h3>Admin Login Form</h3>
                    <hr>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php

require_once __DIR__ . "/partials/footer.php";

?>