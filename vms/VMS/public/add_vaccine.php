<?php

$title = "Add Vaccine";

include '../admin/config.php';

session_start();

if (!isset($_SESSION['pemail'])) {
    header('location: login.php');
    exit();
}

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../admin/assets/css/theme.bundle.css" id="stylesheetLTR" />
    <link rel="icon" href="../admin/assets/favicon/favicon.ico" />
    <title><?php echo "$title"; ?></title>
</head>

<body class="bg-light-green">

    <main class="container" id="login">
        <div class="row align-items-center justify-content-center vh-100">
            <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3 py-6">

                <?php
                $alert1 = '<div class="alert alert-danger fixed-top text-center w-75 mt-2 mx-auto rounded-4" id="insert1" role="alert">Vaccine Already Exist!</div>';
                ?>
                <!-- Title -->
                <h1 class="mb-2 text-center text-uppercase">
                    Add Vaccine
                </h1>

                <!-- Form -->
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Select Vaccine
                                </label>
                                <select name="vaccine" class="form-select" aria-label="Default select example" required>
                                    <option selected disabled> Select Vaccine</option>
                                    <?php

                                    $sql1 = "SELECT * FROM `list_of_vaccines`";

                                    $fetch = mysqli_query($conn, $sql1);

                                    if (mysqli_num_rows($fetch) > 0) {
                                        while ($row = mysqli_fetch_assoc($fetch)) {

                                    ?>
                                            <option required value='<?php echo $row['drug_id'] ?>'><?php echo $row['drug_Name'] ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-4">
                                <!-- Label -->
                                <label class="form-label">
                                    Availability
                                </label>
                                <select name="availab" required class="form-select" aria-label="Default select example">
                                    <option disabled> Select Availability</option>
                                    <option value='AVAILABLE'>Available</option>
                                    <option value='UNAVAILABLE'>Unavailable</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- / .row -->

                    <div class="row align-items-center text-center">
                        <div class="col-12">
                            <!-- Button -->
                            <button type="submit" name="add_vac" class="btn w-100 btn-primary mt-6 mb-2">Add Vaccine</button>
                        </div>
                    </div> <!-- / .row -->
                </form>
            </div>
        </div>
        <?php

        // // check exists
        // if (isset($_POST['add_vac'])) {

        //     $v_name = $_POST['vaccine'];

        //     $e = "SELECT V_id FROM dropdown WHERE V_id = $v_name AND H_id '" . $_SESSION["hid"] . "'";

        //     $ee = mysqli_query($conn, $e);

        //     if (mysqli_num_rows($ee) > 0) {
        //         die($alert1);
        //     }
        // }

        // 
        ?>

        <?php

        if (isset($_POST['add_vac'])) {

            $vid = $_POST['vaccine'];
            $v_avail = $_POST['availab'];
            $h_id = $_SESSION["hid"];

            echo $sql = "INSERT INTO dropdown(`H_id`, `V_id`, `V_avai`) VALUES ($h_id, $vid,'$v_avail')";

            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<script>window.location.replace("./vaccines.php");</script>';
            }
        }

        ?>
        </div>

</body>

<!-- Theme JS -->
<script src="../admin/assets/js/theme.bundle.js"></script>