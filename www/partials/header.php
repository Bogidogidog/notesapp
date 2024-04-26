<?php 
require 'config/database.php';

?>
<!DOCTYPE HTML>
<php lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Notes App</title>
        <!-- CUSTOM STYLESHEET -->
        <link rel="stylesheet" href="<?= ROOT_URL ?>csss/style.css">
        <!-- ICONSCOUT CDN -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <!-- GOOGLE FONT(MONTSERATE) -->
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,800;1,700&display=swap"
            rel="stylesheet">
    </head>

    <body>
        <nav>
            <div class="container nav__container">
                <a href="<?= ROOT_URL ?>index.php" class="nav__logo">Notes</a>
                <section class="search__bar">
                    <form class="container search__bar-container" action="<?=ROOT_URL?>search.php" method="GET">
                        <div>
                            <i class="uil uil-search"></i>
                            <input type="search" name="search" placeholder="Search">
                            <button type="submit" name="submit" class="btn">Go</button>
                        </div>

                    </form>
                </section>
                <ul class="nav__items">
                    <?php if(isset($_SESSION['user-id'])) : ?>
                    <li class="nav__profile">
                        <div class="avatar">
                            <i class="uil uil-user"></i>
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>signin.php">SignIn</a></li>
                    <?php endif ?>
                </ul>

                <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
                <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
            </div>
        </nav>