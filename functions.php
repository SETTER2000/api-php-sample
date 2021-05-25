<?php
function get_json($arr)
{
    while ($item = mysqli_fetch_assoc($arr)) {
        $item_list[] = $item;
    }

    echo json_encode($item_list);
}

function get_posts($db)
{
    get_json(mysqli_query($db, "SELECT * FROM `message` ORDER BY message_id DESC "));
}

function get_post($db, $id)
{
    $post = mysqli_query($db, "SELECT * FROM `message` WHERE `message_id` = '$id'");
    if (mysqli_num_rows($post) < 1) {
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "Not Found"
        ];
        echo json_encode($res);
    } else {
        get_json($post);
    }
}

function add_post($db, $data)
{
    $user = $data['user'];
    $text = $data['text'];
    $title = $data['title'];
    mysqli_query($db, "INSERT INTO `message` (`message_id`, `text`, `user_id`, `date_created`, `title`) VALUES (NULL ,'$text', '$user',NOW(), '$title')");
    http_response_code(201);
    $res = [
        "status" => true,
        "message_id" => mysqli_insert_id($db),
        "message" => "Created successfully"
    ];
    echo json_encode($res);
}

function update_post($db, $id, $data)
{
    $user = $data['user'];
    $text = $data['text'];
    $title = $data['title'];
    mysqli_query($db, "UPDATE `message` SET `text`='$text', `user_id`='$user', `title`='$title' WHERE `message_id`='$id'");
    http_response_code(200);
    $res = [
        "status" => true,
        "message" => "Updated successfully"
    ];
    echo json_encode($res);
}

function delete_post($db, $id)
{
    mysqli_query($db, "DELETE FROM `message` WHERE `message_id`='$id'");
    http_response_code(200);
    $res = [
        "status" => true,
        "message" => "Deleted successfully"
    ];
    echo json_encode($res);
}