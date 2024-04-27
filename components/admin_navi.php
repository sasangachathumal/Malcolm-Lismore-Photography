<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img class="navbar-brand-img" src="./assets/img/logo/logo-white.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
            <ul class="navbar-nav">

                <!-- <?php if (isset($active) && $active == 'home') { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="./dashboard.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./dashboard.php">Home</a>
                    </li>
                <?php } ?> -->

                <?php if (isset($active) && $active == 'enquiry') { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="./enquiries_manage.php">Enquiries <span class="sr-only">(current)</span></a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./enquiries_manage.php">Enquiries</a>
                    </li>
                <?php } ?>

                <?php if (isset($active) && $active == 'gallery') { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="./gallery_manage.php">Gallery <span class="sr-only">(current)</span></a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./gallery_manage.php">Gallery</a>
                    </li>
                <?php } ?>

                <?php if (isset($active) && $active == 'package') { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="./packages_manage.php">Packages <span class="sr-only">(current)</span></a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./packages_manage.php">Packages</a>
                    </li>
                <?php } ?>

            </ul>
            <div class="d-flex">
                <button class="btn btn-outline-light" id="logoutBtn">Logout</button>
            </div>
        </div>
    </div>
</nav>