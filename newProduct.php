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
                        <h3 class="panel-title">New Product</h3>
                    </div>
                    <div class="panel-body">
                        <form name="newProduct" role="form" action="validateProduct.php" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control"
                                           value=""
                                           name="title"
                                           placeholder="Title"
                                           type="text">
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control"
                                           value=""
                                           name="price"
                                           placeholder="0.00"
                                           type="text">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input class="form-control"
                                           value=""
                                           name="desc"
                                           placeholder="Item Description"
                                           type="text">
                                </div>
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input class="form-control"
                                           name="picture"
                                           type="file">
                                </div>
                                <input type="submit" class="btn btn-lg btn-info btn-block" value="Upload!"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

