<!DOCTYPE html>
<html>
<head>
    <title>COMP 3015</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div id="wrapper">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h1 class="login-panel text-center text-muted">
                    COMP 3015 Final
                </h1>
                <hr/>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Create Account</h3>
                    </div>
                    <div class="panel-body">
                        <form name="signup" role="form" action="redirect.php?from=signup" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control"
                                           value=""
                                           name="first"
                                           placeholder="First Name"
                                           type="text">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control"
                                           value=""
                                           name="last"
                                           placeholder="Last Name"
                                           type="text">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control"
                                           value=""
                                           name="email"
                                           placeholder="Email"
                                           type="text">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control"
                                           name="password"
                                           placeholder="Password"
                                           type="password">
                                </div>
                                <div class="form-group">
                                    <label>Verify Password</label>
                                    <input class="form-control"
                                           name="verify_password"
                                           placeholder="Verify"
                                           type="password">
                                </div>
                                <input type="submit" class="btn btn-lg btn-info btn-block" value="Sign Up!"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <a class="btn btn-sm btn-default" href="login.php">Login</a>
            </div>
        </div>

    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

