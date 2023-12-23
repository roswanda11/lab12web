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

## **Langkah-lankgah Praktikum**

• **DDL: Table user**

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

**• File: login_session.php**

```php
<?php
session_start();
if (!isset($_SESSION['isLogin']))
header('location: login.php');
?>
```


• **File: login.php**

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

<img src="https://github.com/dipca0895/Lab12PHP_Form_Login/blob/main/gambar/login.png" width=70% height=70%>



















