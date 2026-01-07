<?php
include 'library/database.php';
include 'library/config.php';

if (isset($_GET['cid'])) {
    $cid = (int) $_GET['cid'];

    // Fetch the filename from the database
    $sql = "SELECT file_upload FROM flowcommand WHERE cid = ?";
    $result = dbQuery($sql, "i", [$cid]);

    if ($row = dbFetchArray($result)) {
        $filename = $row['file_upload'];
        $filepath = 'admin/' . $filename;

        if ($filename && file_exists($filepath)) {
            // Clean the filename for the download header (remove path info)
            $basename = basename($filename);

            // Set headers for download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $basename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));

            // Clear output buffer and read the file
            ob_clean();
            flush();
            readfile($filepath);
            exit;
        } else {
            die("File not found.");
        }
    } else {
        die("Invalid record.");
    }
} else {
    die("No file ID specified.");
}
?>