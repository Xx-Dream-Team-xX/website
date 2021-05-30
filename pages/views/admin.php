<?php
    onlyFor(User::ADMIN);
?>

<!DOCTYPE html>
<html>
<head>
    <?php include(get_path('partials','head.php'));?>
    <title>Panneau Admin</title>
    <script src="/static/js/manageDates.js" charset="utf-8"></script>
    <script src="/static/js/addUser.js" charset="utf-8"></script>
</head>
<body>
    <?php include(get_path('partials','navbar.php'));?>
    <!-- MAIN (FORM) -->

    

    <!-- MAIN (FORM) -->
    <?php include(get_path('partials','footer.php'));?>
</body>

</html>
