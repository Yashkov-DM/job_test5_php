<?php

function get_group(){
    $x = $_GET;
    $id = $x['id'];
    if (!$id) $id = 0;
    require 'config/connect.php';
    $sql = "SELECT * FROM groups WHERE id_parent = $id";
    $result = $conn->query($sql);
    $arr = $result->fetch_all();
    $conn -> close();
    if(empty($arr)){
        require 'config/connect.php';
        $sql = "SELECT * FROM groups WHERE id = $id";
        $result = $conn->query($sql);
        $arr = $result->fetch_all();
        $conn -> close();
    }
    return $arr;
}

function build_tree($arr){
    echo "<ul>";
    foreach ($arr as $value){
        echo "<li><a href=index.php?id=$value[0]>$value[2]</a></li>";
        foreach ($value as $item){
            if (is_array($item)){
                build_tree($item);
            }
        }
    } echo "</ul>";
}

function get_product(){
    require 'config/connect.php';
    $x = $_GET;
    $id = $x['id'];
    if (!$id) $id = 0;
    $sql = "WITH recursive r (id, id_parent, name) AS (
          SELECT     id, id_parent, name
          FROM       groups
          WHERE      id_parent = $id
          UNION ALL
          SELECT     g.id, g.id_parent, g.name
          FROM       groups g
          INNER JOIN r ON g.id_parent = r.id
        )
        SELECT p.name FROM products p 
        JOIN r ON p.id_group = r.id;";
    $result = $conn->query($sql);
    $arr = $result->fetch_all();
    $conn -> close();
    if(empty($arr)){
        require 'config/connect.php';
        $sql = "SELECT `products`.`name` FROM products WHERE id_group = $id";
        $result = $conn->query($sql);
        $arr = $result->fetch_all();
        $conn -> close();
    }
    foreach($arr as $value){
        echo $value[0] . "<br>";
    }
    return $arr;
}

