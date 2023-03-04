<?php

  function getLatest($select, $table, $order, $limit = 13) {
    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order ASC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
  }
?>