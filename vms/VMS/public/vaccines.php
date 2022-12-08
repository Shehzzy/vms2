<?php

$page = "Vaccine";
$show = 'Vaccine';

include "../admin/config.php";

session_start();

if (!isset($_SESSION['pemail'])) {
    header('location: login.php');
    exit();
}


if ($_SESSION["role"] == 2) {
    $title = "Patient";
    header('location: login.php');
} else if ($_SESSION["role"] == 3) {
    $title = "Hospital";
}

include_once 'header.php';

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../admin/assets/css/theme.bundle.css" id="stylesheetLTR" />
    <link rel="icon" href="../admin/assets/favicon/favicon.ico" />
    <title><?php echo "$title"; ?></title>
</head>

<body>

    <!-- THEME CONFIGURATION -->
    <script>
        let themeAttrs = document.documentElement.dataset;

        for (let attr in themeAttrs) {
            if (localStorage.getItem(attr) != null) {
                document.documentElement.dataset[attr] = localStorage.getItem(attr);

                if (theme === 'auto') {
                    document.documentElement.dataset.theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        e.matches ? document.documentElement.dataset.theme = 'dark' : document.documentElement.dataset.theme = 'light';
                    });
                }
            }
        }
    </script>

    <?php include './sidebar.php' ?>

    <!-- MAIN CONTENT -->
    <main>

        <!-- HEADER -->
        <header class="container-fluid d-flex py-6 mb-4">

            <!-- Top buttons -->
            <div class="d-flex align-items-center ms-auto me-n1 me-lg-n2">

                <!-- Switcher -->
                <?php include 'themeswitcher.php' ?>

                <!-- Separator -->
                <div class="vr bg-gray-700 mx-2 mx-lg-3"></div>

                <!-- Dropdown -->
                <?php include 'public_session.php' ?>
            </div>
        </header>

        <div class="container-fluid">

            <!-- Title -->
            <h1 class="h2 display-4 text-uppercase">
                Vaccine
            </h1>


            <div class="row">
                <div class="col">
                    <!-- Card -->
                    <div class="card border-0 flex-fill w-100 shadow-lg" id="users">
                        <div class="card-header border-0 card-header-space-between">

                            <!-- Title -->
                            <h2 class="card-header-title h4 text-uppercase">
                                Vaccines
                            </h2>

                            <a href="add_vaccine.php" class="btn btn-light text-uppercase">
                                Add Vaccine
                            </a>

                        </div>

                        <?php

                        $limit = 6;
                        if (!isset($_GET['page'])) {
                            $page = 1;
                        } else {
                            $page = $_GET['page'];
                        }
                        $offset = ($page - 1) * $limit;

                        $sql = "SELECT * FROM `dropdown` dr
                        INNER JOIN hospital hos ON dr.H_id = hos.H_id
                        INNER JOIN list_of_vaccines lov ON dr.V_id = lov.drug_id
                        WHERE dr.H_id = '" . $_SESSION["hid"] . "' 
                        ORDER BY id DESC
                        LIMIT {$offset},{$limit}";

                        ?>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table align-middle table-edge table-hover table-nowrap mb-0 text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Vaccine Name</th>
                                        <th>Status</th>
                                        <th>Change Availability</th>
                                    </tr>
                                </thead>
                                <?php

                                $fetch = mysqli_query($conn, $sql);

                                foreach ($fetch as $row) {

                                ?>
                                    <?php if ($row['H_id'] == $_SESSION["hid"]) { ?>

                                        <tbody class="list">
                                            <tr>
                                                <td><?php echo $row['H_Name'] ?></td>
                                                <td><?php echo $row['drug_Name'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['V_avai'] == 'AVAILABLE') {
                                                    ?>
                                                        <a class="badge bg-success rounded-3">AVAILABLE</a>
                                                    <?php
                                                    } else if ($row['V_avai'] == 'UNAVAILABLE') {
                                                    ?>
                                                        <a class="badge bg-danger rounded-3">UNAVAILABLE</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['V_avai'] == 'UNAVAILABLE') {
                                                    ?>
                                                        <a href="available.php?uid=<?php echo $row['id'] ?>" class="btn btn-sm btn-success rounded-3">AVAILABLE</a>
                                                    <?php
                                                    } else if ($row['V_avai'] == 'AVAILABLE') {
                                                    ?>
                                                        <a href="unavailable.php?uid=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger rounded-3">UNAVAILABLE</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                        </div> <!-- / .table-responsive -->

                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-5 text-secondary small">
                                    <!-- Showing: <span class="list-pagination-page-first"></span> - <span class="list-pagination-page-last"></span> of <span class="list-pagination-pages"></span> -->
                                </div>

                                <!-- Pagination -->
                                <ul class="pagination list-pagination mb-0">
                                    <!-- pagination start -->
                                    <?php

                                    $sql1 = "SELECT * FROM `dropdown` dr
                                    INNER JOIN hospital hos ON dr.H_id = hos.H_id
                                    INNER JOIN list_of_vaccines lov ON dr.V_id = lov.drug_id
                                    WHERE dr.H_id = '" . $_SESSION["hid"] . "'";

                                    $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");


                                    if (mysqli_num_rows($result1) > 0) {

                                        $total_records = mysqli_num_rows($result1);

                                        $total_page = ceil($total_records / $limit);

                                        // pagination limit
                                        $count = 4;
                                        $startPage = max(1, $page - $count);
                                        $endPage = min($total_page, $page + $count);
                                        // pagination limit end

                                        echo '<ul class="pagination justify-content-center">';

                                        if ($page > 1) {
                                            echo '<li class="page-item"><a class="page-link border-0 rounded me-2" href="vaccines.php?page=' . ($page - 1) . '">Previous</a></li>';
                                        }

                                        for ($i = $startPage; $i <= $endPage; $i++) {
                                            if ($i == $page) {
                                                $active = "active";
                                            } else {
                                                $active = "";
                                            }
                                            echo '<li class="page-item ' . $active . '"><a class="page-link border-0 rounded px-4 me-2" href="vaccines.php?page=' . $i . '">' . $i . '</a></li>';
                                        }
                                        if ($total_page > $page) {
                                            echo '<li class="page-item"><a class="page-link border-0 rounded me-2" href="vaccines.php?page=' . ($page + 1) . '">Next</a></li>';
                                        }
                                        echo '</ul>';
                                    } else {
                                        echo '<h3 class="text-center h2">No Vaccine Available</h3>';
                                    }

                                    ?>
                                    <!-- pagination end -->
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container-fluid -->
    </main> <!-- / main -->
    <!-- Theme JS -->


</body>

</html>