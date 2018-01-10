
<?php
if (isset($_POST))
{
    $msg="";
    $responce=200;

    $rsp = array(
        'response' => $responce,
        'msg' => $msg
    );

    echo json_encode($rsp);
}

?>
