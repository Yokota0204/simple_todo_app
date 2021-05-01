<?php
  phpinfo();
  $json_array = array(
    "uid" => 1,
    "name" => "Yohei Yokota",
    "email" => "yokota.02210301@gmail.com"
  );
  $json = json_encode($json_array);
  echo $json;
?>