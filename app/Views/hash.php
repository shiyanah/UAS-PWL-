<?php
// Untuk generate password hash
$password = '1234'; // password yang mau di-hash
echo password_hash($password, PASSWORD_DEFAULT);
