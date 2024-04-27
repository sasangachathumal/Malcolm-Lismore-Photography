<?php
include('./components/head.php');

?>

<body class="landing-page">

    <?php include('./components/client_navi.php'); ?>

    <div class="page-header page-header-small">
        <div class="page-header-image" data-parallax="true" style="background-image: url('./assets/img/bg5.jpg');">
        </div>
        <div class="content-center">
            <div class="container">
                <h1 class="title">Photo Gallery</h1>
            </div>
        </div>
    </div>

    <div class="section" id="gallery">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4" id="galleryContainer">
            </div>
        </div>
    </div>

    <?php
    include('./components/footer-copyright.php');
    include('./components/external-js.php');
    ?>
    <script>
        function getGalleryImages() {
            $.ajax({
                url: "./controllers/gallery_controller.php",
                type: "POST",
                cache: false,
                data: {
                    action: 'listGallery'
                },
                success: function(data) {
                    $('#galleryContainer').html(data);
                }
            });
        }

        $(document).ready(function() {
            getGalleryImages();

            var home = $('#homeClientBtn').parent();
            var service = $('#serviceClientBtn').parent();
            var gallery = $('#galleryClientBtn').parent();
            var about = $('#aboutClientBtn').parent();

            home.removeClass('active');
            service.removeClass('active');
            gallery.removeClass('active');
            about.removeClass('active');
            gallery.addClass('active');
        });
    </script>

</body>

</html>