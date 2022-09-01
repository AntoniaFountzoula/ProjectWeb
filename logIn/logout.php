<?php
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['Id']);
    header('Location: login.html');

