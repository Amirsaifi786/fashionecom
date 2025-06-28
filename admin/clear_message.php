<?php
session_start();
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
unset($_SESSION['missing_fields']);
echo "Messages cleared";
?>
