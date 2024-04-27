<?php
session_start();
if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === true && isset($_SESSION['userId'])) {
    include('./components/head.php');
    $active = 'info';
?>

    <body>

        <?php include('./components/admin_navi.php'); ?>

        <div class="container-fluid">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Business Info</li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid">
            <h2>Customer Enquiries</h2>
        </div>

        <?php
        include('./components/footer-copyright.php');
        include('./components/external-js.php');
        ?>

    </body>

    </html>
<?php } ?>