<?php

include '../admin/config.php';

if (isset($_POST['city'])) {

    $city = $_POST['city'];

    echo '<option selected disabled value="">Select Vaccine</option>';
    
    $query = "SELECT * FROM `dropdown` dr
    INNER JOIN hospital hos ON dr.H_id = hos.H_id
    INNER JOIN list_of_vaccines lov ON dr.V_id = lov.drug_id
    WHERE dr.H_id = $city AND V_avai = 'AVAILABLE'";

    $fetch = mysqli_query($conn, $query);

    if (mysqli_num_rows($fetch) > 0) {
        while ($row = mysqli_fetch_assoc($fetch)) {
?>
            <option value='<?php echo $row['drug_id'] ?>'><?php echo $row['drug_Name'] ?></option>
<?php
        }
    } else {
        echo '<option disabled>No Vaccine found!</option>';
    }
}
