<?php
include("db.php");

if (isset($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";
    $stmt = $mysqli->prepare("SELECT * FROM watch_brands WHERE brand_name LIKE ? ORDER BY founded_year DESC");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $sql = "SELECT * FROM watch_brands ORDER BY founded_year DESC";
    $results = $mysqli->query($sql)->fetch_all(MYSQLI_ASSOC);
}

print(json_encode($results));
?>
