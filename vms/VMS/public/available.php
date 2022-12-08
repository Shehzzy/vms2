<?php

include '../admin/config.php';

if (isset($_GET['uid'])) {
    mysqli_query($conn, "UPDATE `dropdown` SET `V_avai` = 'AVAILABLE' WHERE id = '$_GET[uid]'");
    header("Location: vaccines.php");
}
?>