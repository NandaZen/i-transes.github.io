<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once('../../koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email']) && !empty($_POST['kata_sandi'])) {
        $email = trim($_POST['email']);
        $kata_sandi = trim($_POST['kata_sandi']);

        // Query untuk mendapatkan pengguna berdasarkan email
        $query = "SELECT * FROM pengguna WHERE email = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Jika kata_sandi sudah di-hash, gunakan password_verify
            if (strlen($row['kata_sandi']) >= 60) {
                if (password_verify($kata_sandi, $row['kata_sandi'])) {
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['peran'] = $row['peran'];
                    $_SESSION['nama'] = $row['nama']; // <<< ini
                    redirectBasedOnRole($row['peran']);
                }
                 else {
                    handleLoginError('Kata sandi salah!');
                }
            } else {
                // Jika kata_sandi belum di-hash, lakukan pengecekan password biasa
                if ($kata_sandi === $row['kata_sandi']) {
                    // Hash password lama
                    $hashedPassword = password_hash($kata_sandi, PASSWORD_DEFAULT);

                    // Update password lama menjadi hash di database
                    $updateQuery = "UPDATE pengguna SET kata_sandi = ? WHERE email = ?";
                    $updateStmt = $koneksi->prepare($updateQuery);
                    $updateStmt->bind_param("ss", $hashedPassword, $row['email']);
                    if ($updateStmt->execute()) {
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['peran'] = $row['peran'];
                        $_SESSION['nama'] = $row['nama'];

                        redirectBasedOnRole($row['peran']);
                    } else {
                        handleLoginError('Gagal memperbarui password!');
                    }
                } else {
                    handleLoginError('Kata sandi salah!');
                }
            }
        } else {
            handleLoginError('Email pengguna tidak ditemukan!');
        }

        $stmt->close();
    } else {
        handleLoginError('Harap isi data dengan lengkap!');
    }
}

function handleLoginError($message)
{
    $_SESSION['login_error'] = $message; // Simpan pesan error di session
    header('Location: masuk.php'); // Redirect ke halaman login agar pesan error ditampilkan
    exit();
}

function redirectBasedOnRole($peran)
{
    switch ($peran) {
        case 'pengguna':
            header("Location: ../pengguna/pengguna.php");
            break;
        case 'admin':
            header("Location: ../admin/admin.php");
            break;
        default:
            header("Location: masuk.php");
            exit();
    }
    exit();
}
?>
