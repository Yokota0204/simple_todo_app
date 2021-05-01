<?php
  function return_environment() {
    $environments = ['dev', 'it', 'stg', 'prd'];
    return $environments[0];
  }

  function return_debug_flag() {
    return true;
  }
?>