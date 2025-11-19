<?php
session_start();
session_destroy();
header("Location: ../catalogo_v3.php");
exit;
