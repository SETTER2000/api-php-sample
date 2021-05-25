<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: json/application');

require 'conf.php';
require 'functions.php';
$method = $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'];
list($type, $id) = explode('/', $q);

if ($method === 'GET') {
    if ($type === 'posts') {
        if (isset($id)) {
            get_post($db, $id);
        } else {
            get_posts($db);
        }
    }
} elseif ($method === 'POST') {
    if ($type === 'posts') {
        add_post($db, $_POST);
    }
} elseif ($method === 'PATCH') {
    if ($type === 'posts') {
        if (isset($id)) {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            update_post($db, $id, $data);
        }

    }
} elseif ($method === 'DELETE') {
    if ($type === 'posts') {
        if (isset($id)) {
            delete_post($db, $id);
        }

    }
}
