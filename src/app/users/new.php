<?php
  require("../modules/general.php");

  $header = template("../templates/_header.php");
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/bootstrap_5.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/users/new.css" rel="stylesheet">
  </head>
  <body>
    <div class="contents">
      <?php echo $header; ?>
      <div class="container">
        <form action="register.php" method="post">
          <div class="form-group">
            <label>Nickname</label>
            <input name="name" type="text" class="form-control" placeholder="Enter your nickname">
          </div>
          <div class="form-group">
            <label>Email address</label>
            <input name="email" type="email" class="form-control" placeholder="Enter email">
            <small class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input name="password" type="password" class="form-control" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
    <script src="bootstrap_5.0.0/js/bootstrap.min.js"></script>
  </body>
</html>