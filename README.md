<table>
  <tr>
    <th colspan="2">DATA MAHASISWA</th>
  </tr>
  <tr>
    <td>Nama</td>
    <td>Roswanda Nuraini</td>
  </tr>
  <tr>
    <td>NIM</td>
    <td>312210328</td>
  </tr>
  <tr>
    <td>Kelas</td>
    <td>TI.22.A3</td>
  </tr>
</table>

# <p align="center">Praktikum12 :PHP dan MySQL Database </p>

# Studi Kasus: Login Form

## **Langkah-langkah Praktikum**

## 1. Membuat DDL: Table User.

```sql
CREATE TABLE `user`(
`id` INT NOT NULL AUTO_INCREMENT,
`username` VARCHAR(50),
`password` VARCHAR(50),
PRIMARY KEY (`id`),
UNIQUE INDEX `UNIQUE` (`username`)
) ENGINE=MYISAM;
INSERT INTO `user` (`username`, `password`) VALUES ('admin', md5('admin'));
```

![Screenshot (606)](https://github.com/roswanda11/lab12web/assets/115516632/00b29570-e6e0-4b9b-90a6-7fbef7b2c42d)

- Di database sekarang sudah ada tabel user untuk admin

## 2. Membuat File: login_session.php

Deskripsi: digunakan untuk pengecekan sesi login, file ini nantinya akan di include di setiap halaman yang membutuhkan login.

```php
<?php
session_start();
if (!isset($_SESSION['isLogin']))
header('location: login.php');
?>
```

## 3. Membuat File: login.php

```php
<?php
session_start();
$title = 'Data Barang';
include_once 'koneksi.php';
if (isset($_POST['submit']))
{
 $user = $_POST['user'];
 $password = $_POST['password'];

 $sql = "SELECT * FROM user WHERE username = '{$user}'

AND password = md5('{$password}') ";
$result = mysqli_query($conn, $sql);
    if ($result && mysqli_affected_rows($conn) != 0)
    {
        $_SESSION['isLogin'] = true;
        $_SESSION['user'] = mysqli_fetch_array($result);
        header('location: index.php');
    } else
        $errorMsg = "<p style=\"color:red;\">Gagal Login,
        silakan ulangi lagi.</p>";
    }
include_once "header.php";
if (isset($errorMsg)) echo $errorMsg;
?>
<h2>Login</h2>
<form method="post">
    <div class="input">
        <label>Username</label>
        <input type="text" name="user" />
    </div>
    <div class="input">
        <label>Password</label>
        <input type="password" name="password" />
    </div>
    <div class="submit">
        <input type="submit" name="submit" value="Login" />
    </div>
</form>
<?php
include_once 'footer.php';
?>

```
## 4. Membuat File: login.php

```
<?php
session_destroy();
header('location: ' . site_url('/'));
?>
```
## 5. Membuat method logout seperti berikut :
```
<?php
session_destroy();
header('location: ' . site_url('/'));
?>
```
- Saya menggunakan project sebelumnya yaitu rpoject CRUD untuk data barang. maka tampilan index akan seperti ini:

![image](https://github.com/roswanda11/lab12web/assets/115516632/54cf8712-9b2f-4244-9133-782e2b83936e)

- Terlihat ada menu login di header. saya telah menambahkannya. jika di klik akan seperti ini:

![image](https://github.com/roswanda11/lab12web/assets/115516632/1e0286ea-6865-49a2-a46d-70c9e101a172)

- Sekarang kita bisa melakukan login session. note : untuk username : admin untuk password : admin

![image](https://github.com/roswanda11/lab12web/assets/115516632/f026cb80-ab57-4e86-82ef-e1c9ba6b9eb2)

- Jika sudah berhasil login maka bagian login akan berubah jadi logout. sekarang, tugas kita adalah mengisi artikel dan membuat CRUD untuk artikel.

## 6. Membuat tabel database untuk artikel.

```
    CREATE TABLE artikel (
    id INT(11) auto_increment,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    PRIMARY KEY(id)
    );
```

![image](https://github.com/roswanda11/lab12web/assets/115516632/0d47a291-ca7b-4137-afa7-ae4fc669744f)

- Di database sekarang sudah ada tabel artikel. selanjutnya:

## 7. Kita isi tabelnya dengan konten :

```
    INSERT INTO artikel (judul, isi, slug) VALUE
    ('Artikel pertama', 'Lorem Ipsum adalah contoh teks atau dummy dalam industri 
    percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi 
    standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak 
    dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah 
    buku contoh huruf.', 'artikel-pertama'), 
    ('Artikel kedua', 'Tidak seperti anggapan banyak orang, Lorem Ipsum bukanlah 
    teks-teks yang diacak. Ia berakar dari sebuah naskah sastra latin klasik dari 
    era 45 sebelum masehi, hingga bisa dipastikan usianya telah mencapai lebih 
    dari 2000 tahun.', 'artikel-kedua');
    
```
- Nah jika sudah maka data akan berubah.

![image](https://github.com/roswanda11/lab12web/assets/115516632/c297bf8b-681f-4bb7-8f53-7d4b7e142def)

## 8. Sekarang kita akan mengisi bagian artikel dengan data yang sudah kita tambahkan. Caranya :

```
<?php
include_once('template/header.php');
include("koneksi.php");

$sql = 'SELECT * FROM artikel';
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan */
    </style>
    <title>Home</title>
</head>
<body>
    <div class="container">
        <h1>Artikel Terbaru</h1>

        <div class="main">
            <?php if ($result): ?>
                <?php while ($row = mysqli_fetch_array($result)): ?>
                    <article class="entry">
                        <h2><a href="detail_artikel.php?id=<?= $row['id']; ?>"><?= $row['judul']; ?></a></h2>
                        <p><?= substr($row['isi'], 0, 200); ?></p>
                    </article>
                    <hr class="divider" />
                <?php endwhile; ?>
            <?php else: ?>
                <p>Belum ada artikel.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php include_once('template/footer.php'); ?>
```

- Maka outputnya akan seperti ini :

![image](https://github.com/roswanda11/lab12web/assets/115516632/6dc17884-72bb-4dce-ac81-8dffcaed1cf7)

## 9. Membuat file admin.php di class artikel.

```
<?php
include_once('template/header.php');
include("koneksi.php");

$sql = 'SELECT * FROM artikel';
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <style>
        th {
            background-color: pink;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 16px;
            font-weight: normal;
        }

        .tambah-button {
            background-color: pink;
            border: none;
            color: white;
            padding: 10px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 8px 6px;
            cursor: pointer;
            font-weight: normal;
        }
    </style>
    <title>Data Artikel</title>
</head>
<body>
    <div class="container">
        <h1>Data Artikel</h1>
        <a href="/lab12_php_login/module/artikel/add.php" class="tambah-button">Tambah Artikel</a>

        <div class="main">
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Slug</th>
                    <th>Aksi</th>
                </tr>
                <?php if ($result): ?>
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?= $row['judul']; ?></td>
                            <td><?= substr($row['isi'], 0, 200); ?></td>
                            <td><?= $row['slug']; ?></td>
                            <td>
                                <a href="/lab12_php_login/module/artikel/ubah.php?id=<?= $row['id']; ?>">Ubah</a>
                                <a href="/lab12_php_login/module/artikel/hapus.php?id=<?= $row['id']; ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Belum ada data</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php include_once('template/footer.php'); ?>
```

- Maka tampilannya akan seperti ini :

![image](https://github.com/roswanda11/lab12web/assets/115516632/237bb491-f028-4cb5-8d0b-15c81d9e0dff)

## 10. Sekarang kita buat file add.php untuk menambahkan artikel.

```
<?php
include("koneksi.php");

$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses form tambah data artikel
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $slug = $_POST['slug'];

    // Lakukan validasi dan simpan data ke database
    $sql = "INSERT INTO artikel (judul, isi, slug) VALUES ('$judul', '$isi', '$slug')";

    if (mysqli_query($conn, $sql)) {
        $successMessage = 'Data berhasil ditambahkan.';
    } else {
        $errorMessage = 'Error: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Tambah Artikel</title>
</head>
<body>
    <div class="container">
        <h1>Tambah Artikel</h1>

        <?php if (!empty($successMessage)): ?>
            <p style="color: green;"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label>Judul</label>
            <input type="text" name="judul" required>

            <label>Isi</label>
            <textarea name="isi" rows="4" required></textarea>

            <label>Slug</label>
            <input type="text" name="slug" required>

            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
```

- Outputnya akan seperti ini saat kita klik button tambah artikel

![image](https://github.com/roswanda11/lab12web/assets/115516632/446101fa-a7c3-4f23-bbb5-e0e14cc32f8d)

- Misal kita tambahkan data baru seperti berikut:

![image](https://github.com/roswanda11/lab12web/assets/115516632/51c456c6-4a97-4a83-a85f-7142d7c3b8ec)

- Setelah di klik simpan maka data baru akan muncul seperti berikut :

![image](https://github.com/roswanda11/lab12web/assets/115516632/c7000b9d-e73b-4bea-a157-73fc0c687ab1)

![image](https://github.com/roswanda11/lab12web/assets/115516632/2cb0538c-65be-4848-9980-ec5ec20777f3)

## 11. Buat file ubah.php untuk mengubah data.

```
<?php
include("koneksi.php");

$id = $_GET['id'];
$successMessage = $errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses form ubah data artikel
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $slug = $_POST['slug'];

    // Lakukan validasi dan perbarui data di database
    $sqlUpdate = "UPDATE artikel SET judul='$judul', isi='$isi', slug='$slug' WHERE id=$id";

    if (mysqli_query($conn, $sqlUpdate)) {
        $successMessage = 'Data berhasil diubah.';
    } else {
        $errorMessage = 'Error updating data: ' . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM artikel WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Ubah Artikel</title>
</head>
<body>
    <div class="container">
        <h1>Ubah Artikel</h1>

        <?php
        if (!empty($successMessage)) {
            echo '<p style="color: green;">' . $successMessage . '</p>';
        }
        
        if (!empty($errorMessage)) {
            echo '<p style="color: red;">' . $errorMessage . '</p>';
        }
        ?>

        <form method="post" action="">
            <label>Judul</label>
            <input type="text" name="judul" value="<?= $row['judul']; ?>" required>

            <label>Isi</label>
            <textarea name="isi" rows="4" required><?= $row['isi']; ?></textarea>

            <label>Slug</label>
            <input type="text" name="slug" value="<?= $row['slug']; ?>" required>

            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>

```
- Outputnya akan seperti ini :

![image](https://github.com/roswanda11/lab12web/assets/115516632/3465096a-5259-4074-bf68-2cf8bfa76f45)

- Misalnya, kita ingin mengubah judul artikel menjadi ```Artikel ketiga``` :

![image](https://github.com/roswanda11/lab12web/assets/115516632/3f68efc9-7efb-49cb-bd14-6b187cd82a85)

- Setelah di klik simpan maka akan:

![image](https://github.com/roswanda11/lab12web/assets/115516632/3e5edaea-4167-4bb4-bba5-90b15a733694)

- Data pun berhasil diubah.

![image](https://github.com/roswanda11/lab12web/assets/115516632/10c2b2d8-a73c-4495-8c41-c98a93e892d9)

## 12. Setelah itu kita buat file hapus.php untuk menghapus data.

```
<?php
include("koneksi.php");

$id = $_GET['id'];

// Hapus data dari database
$sql = "DELETE FROM artikel WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    $message = "Artikel telah dihapus.";
} else {
    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Hapus Artikel</title>
</head>
<body>
    <div class="container">
        <h1>Hapus Artikel</h1>
        <p><?= $message; ?></p>
    </div>
</body>
</html>

```

- Misal kita ingin menghapus ```Artike ketiga```,saatdi klik akanseperti ini:

![image](https://github.com/roswanda11/lab12web/assets/115516632/bdb4f1a0-9d65-42dc-98a2-aed8bd80bd86)

Dan data pun berhasil diapus.

![image](https://github.com/roswanda11/lab12web/assets/115516632/fb57382a-0eb5-4df6-9413-76b9dc696268)

## 13. Saya membuat file about.php agar tidak kosong 

```
<?php include_once('template/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>About Project</title>
</head>
<body>
    <div class="container">
        <h1>About This Project</h1>

        <p>Welcome to our project!</p>

        <h2>Overview</h2>
        <p>
            This project is a web application built with PHP that allows users to manage articles.
            Users can view a list of articles, read their details, add new articles, edit existing articles, and delete articles.
        </p>

        <h2>Features</h2>
        <ul>
            <li>View a list of articles with their titles, summaries, and images.</li>
            <li>Click on an article to read its full content.</li>
            <li>Add new articles with a title, content, and image.</li>
            <li>Edit existing articles to update their title, content, and image.</li>
            <li>Delete articles to remove them from the system.</li>
        </ul>

        <h2>Technologies Used</h2>
        <ul>
            <li>PHP for server-side scripting.</li>
            <li>MySQL for the database to store article information.</li>
            <li>HTML, CSS, and JavaScript for the frontend interface.</li>
        </ul>

        <h2>How to Use</h2>
        <p>
            To get started, navigate through the available pages using the top navigation menu.
            You can view articles, add new articles, and manage existing articles through the provided functionality.
        </p>

        <h2>Contributors</h2>
        <p>
            This project was created by Roswanda Nuraini and tech by Bapak Agung Nugroho S.kom., M.Kom.
            We hope you find it useful for managing and presenting articles on your website!
        </p>
    </div>
</body>
</html>

<?php include_once('template/footer.php'); ?>

```

- Outputnya akan seperti ini :
  
![image](https://github.com/roswanda11/lab12web/assets/115516632/ebc04fe5-4fe0-476c-9f2e-e4888fa74b8e)

## Terakhir kita akan melakukan sesi logout. Karena diatas kita sudah membuat file logout bersamaan dengan file login, maka sekarang tinggal lita klik saya header logoutnya. 

![image](https://github.com/roswanda11/lab12web/assets/115516632/4171c45f-7af8-4bc7-a472-3946e2cab35c)

Maka tampilan akan kembali ke index, header logout berubah menjadi login, bagian tambah artikel dan about saat kita ingin melihatnya kita harus melakukan login terlebih dahulu.

![image](https://github.com/roswanda11/lab12web/assets/115516632/e7a45bf5-ade0-433b-9452-562eb88d47c7)

![image](https://github.com/roswanda11/lab12web/assets/115516632/29cdcd60-07b2-41ea-a2e1-5994919b4ece)
