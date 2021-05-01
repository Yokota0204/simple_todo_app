<?php
  function return_sql_server() {
    return [
      'server' => '172.21.0.2',
      'username' => 'root',
      'password' => 'example'
    ];
  }

  function template($html_file) {
    $html_data = file_get_contents($html_file);
    return $html_data;
  }

  function template_replace($html_file, $disp_data) { // テンプレート表示用の関数
    $html_data = file_get_contents($html_file); // テンプレートファイルを読み込み
    $replaced = '/_+(.*)+_/'; // 検索するパターンの指定
    $html_data = preg_replace($replaced, $disp_data, $html_data); // 置換実行
    return $html_data; // 表示用のHTMLデータを返す
  }

  function generate_uid($table, $mysqli, $is_mobile) {
    $uid = uniqid(dechex(random_int(0, 255)), true);

    $sql = "SELECT COUNT(*) FROM $table WHERE uid = '$uid';";
    $query = $mysqli->query($sql);

    if (!$query) {
      $error = "Failed to get user count.";
      if ($is_mobile) {
        header('Content-Type: application/json');
        $error = array('error' => $error);
        $error_json = json_encode($error);
        echo $error_json;
      } else {
        echo $error;
        echo $mysqli->error;
      }
    } else {
      if ($count > 0) {
        return generate_uid($table, $is_mobile);
      } else {
        return $uid;
      }
    }
  }
?>