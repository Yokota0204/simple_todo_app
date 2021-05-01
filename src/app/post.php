<?php
  if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit;
  }

  if (!isset($_POST['task'])) {
    exit;
  }

  $task = $_POST['task'];

  if (empty($task)) {
    exit;
  }

  require('modules/general');

  $sql_server = return_sql_server();

  $server = $sql_server['server'];
  $username = $sql_server['username'];
  $password = $sql_server['password'];

  $mysqli = new mysqli($server, $username, $password);

  if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit;
  }

  $db = "todo";
  $tbl_tasks = "tasks";

  $mysqli->select_db($db);

  $sql = "insert into $tbl_tasks(task) values($task);";

  $query = $mysqli->query($sql);

  if (!$query) {
    echo $mysqli->error;
  }
?>