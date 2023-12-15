<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

try {
    // Fetch all rows
    $stmt = $pdo->prepare("SELECT * FROM pembelian");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Specify the row number you want to delete (e.g., 3rd row)
    $rowToDelete = 1;

    // Check if the row exists
    if (isset($rows[$rowToDelete - 1])) {
        // Delete the row
        $idToDelete = $rows[$rowToDelete - 1]['id_pembelian'];
        $deleteStmt = $pdo->prepare("DELETE FROM pembelian WHERE id_pembelian = ?");
        $deleteStmt->execute([$idToDelete]);
        header("Location: Keranjang.php");
        exit;
    } else {
        echo "Row does not exist.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

