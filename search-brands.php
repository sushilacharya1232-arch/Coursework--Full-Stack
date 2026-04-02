<h1>Watch Brand Search</h1>
<hr>
<?php
include("db.php");
$keywords = $_POST['keywords'] ?? '';

$sql = "SELECT * FROM watch_brands";
$stmt = null;

if (!empty($keywords)) {
    $sql .= " WHERE brand_name LIKE ?
              OR brand_description LIKE ?
              OR country LIKE ?
              OR founded_year LIKE ?
              ORDER BY founded_year DESC";

    $search = "%" . $keywords . "%";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $search, $search, $search, $search);
    $stmt->execute();
    $results = $stmt->get_result();
} else {
    $sql .= " ORDER BY founded_year DESC";
    $results = mysqli_query($mysqli, $sql);
}
?>

<table border="1" cellpadding="8">
    <tr>
        <th>Brand Name</th>
        <th>Country</th>
        <th>Founded Year</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($results)): ?>
        <tr>
            <td>
                <a href="brand-details.php?id=<?= $row['brand_id'] ?>">
                    <?= htmlspecialchars($row['brand_name']) ?>
                </a>
            </td>
            <td><?= htmlspecialchars($row['country']) ?></td>
            <td><?= htmlspecialchars($row['founded_year']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>
