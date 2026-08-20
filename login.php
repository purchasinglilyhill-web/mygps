<?php
require_once 'db.php';
if (!empty($_SESSION['user'])) { header('Location: index.php'); exit; }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $u=trim($_POST['username']??''); $p=$_POST['password']??'';
 $st=$pdo->prepare("SELECT * FROM users WHERE username=? AND active=1 LIMIT 1"); $st->execute([$u]); $row=$st->fetch();
 if ($row && hash('sha256',$p)===$row['password_hash']) {
   unset($row['password_hash']); $_SESSION['user']=$row;
   header('Location: index.php'); exit;
 }
 $error='Invalid username or password.';
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>GPS Tracker Login</title>
<link rel="stylesheet" href="assets/style.css"></head><body class="center"><div class="card login">
<h1>GPS Tracker</h1><p class="muted">PHP + MySQL</p>
<?php if($error): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post"><label>Username<input name="username" required autofocus></label><label>Password<input type="password" name="password" required></label><button>Sign In</button></form>
<p class="muted">Demo admin: admin / admin123<br>Demo driver: driver1 / driver123</p></div></body></html>