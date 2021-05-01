<?php
  require("../../environment.php");
  $environment = return_environment();
  $debugging = return_debug_flag();

  $url = "new.php";

  if ($debugging) {
    echo "<a href='$url'>戻る</a>";
  }

  if (!isset($_POST['name'], $_POST['email'], $_POST['password'])) {
    header('Content-Type: application/json');
    $error_message = "No params.";
    $error = array('error' => $error_message);
    $error_json = json_encode($error);
    echo $error_json;
    exit;
    if ($debugging) {
      echo $error_message;
      exit;
    }
  }

  $user_name = $_POST['name'];
  $user_email = $_POST['email'];
  $user_password = $_POST['passwrod'];
  $user_password = password_hash($password, PASSWORD_DEFAULT);
  $is_mobile = $_POST['mobile'] > 0 ? true : false;

  require("../modules/general.php");

  $sql_server = return_sql_server();
  $sql_server_name = $sql_server['server'];
  $sql_username = $sql_server['username'];
  $sql_password = $sql_server['password'];

  $mysqli = new mysqli($sql_server_name, $sql_username, $sql_password);

  if (!$mysqli) {
    if ($is_mobile) {
      header('Content-Type: application/json');
      $error = array('error' => "Database connection error.");
      $error_json = json_encode($error);
      echo $error_json;
      exit;
    } else {
      if ($debugging) {
        echo "Database connection error <br>";
        echo $mysqli->connect_error;
        exit;
      }
    }
    exit;
  }

  $db_users = "users";
  $tbl_users = "users";

  $mysqli->select_db($db_users);

  $sql = "SELECT COUNT(*) FROM $tbl_users WHERE email = '$user_email';";

  $query = $mysqli->query($sql);

  if (!$query) {
    $error = "Failed to get user count.";
    if ($is_mobile) {
      header('Content-Type: application/json');
      $error = array('error' => $error);
      $error_json = json_encode($error);
      echo $error_json;
      exit;
    } else {
      if ($debugging) {
        echo $error;
        echo $mysqli->error;
        exit;
      }
    }
    exit;
  }

  $result = $query->fetch_all();
  $count = $result[0][0];

  if ($count > 0) {
    $error_message = "This email address has already been registered.";
    if ($is_mobile) {
      header('Content-Type: application/json');
      $error = array('error' => $error_message);
      $error_json = json_encode($error);
      echo $error_json;
      exit;
    } else {
      echo $error_message;
    }
    exit;
  }

  $user_uid = generate_uid($tbl_users, $mysqli, $is_mobile);

  $result = $query->fetch_all();
  $count = $result[0][0];

  $sql = "INSERT INTO $tbl_users (uid, name, email, password_digest)
    VALUE ('$user_uid', '$user_name', '$user_email', '$user_password');";

  $query = $mysqli->query($sql);

  if (!$query) {
    $error = "Failed to insert user.";
    if ($is_mobile) {
      header('Content-Type: application/json');
      $error = array('error' => $error);
      $error_json = json_encode($error);
      echo $error_json;
      exit;
    } else {
      if ($debugging) {
        echo $error;
        echo $mysqli->error;
      }
    }
    exit;
  }

  $sql = "SELECT uid, name, email FROM $tbl_users WHERE uid = '$user_uid';";

  $query = $mysqli->query($sql);

  if (!$query) {
    $error = "Failed to get a new user.";
    if ($is_mobile) {
      header('Content-Type: application/json');
      $error = array('error' => $error);
      $error_json = json_encode($error);
      echo $error_json;
      exit;
    } else {
      if ($debugging) {
        echo $error;
        echo $mysqli->error;
        exit;
      }
    }
    exit;
  }

  $result = $query->fetch_all();
  $user = $result[0];
  $user_name = $user[0];
  $user_email = $user[1];

  if ($is_mobile) {
    header('Content-Type: application/json');
    $user_array = array('name' => $user_name, 'email' => $user_email);
    $user_json = json_encode($user_array);

    echo $user_json;
  } else {
    if ($debugging) {
      echo "Succesful registration.";
    }
  }
?>