<?php
session_start();
include 'dbconn.php';

if (isset($_POST['search'])) {
    $gname = strtolower($_POST['search']);
}

if ($gname != null) {
    $stmt = $conn->prepare("SELECT * FROM product WHERE lower(gname) LIKE :gname");
    $stmt->bindParam(':gname', $gnameLike);
    $gnameLike = '%' . $gname . '%';
    $stmt->execute();
    $value = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($value as $item) {
        $get_id[] = $item['g_id'];
        $count++;
    }
}

if (empty($get_id)) { ?>
    <div style="margin-top: 10vh; font-size: 1.7rem; margin-left: 6.5vw; font-family: Poppins, sans-serif;">Not found.</div>
    <div style="margin-top: 1.5vh; font-size: 1.1rem; margin-left: 6.5vw; font-family: Poppins, sans-serif;">Redirecting to
        the homepage . . .</div>
<?php
} else {
    $queryString = http_build_query($get_id);
    header("location: user.php?count=$count&$queryString");
}
?>