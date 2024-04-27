<?php
include('./components/head.php');
$active = 'contact';
?>

<body class="landing-page">

    <?php include('./components/client_navi.php'); ?>

    <div class="page-header page-header-small">
        <div class="page-header-image" data-parallax="true" style="background-image: url('./assets/img/bg6.jpg');">
        </div>
        <div class="content-center">
            <div class="container">
                <h1 class="title">Contact Us</h1>
            </div>
        </div>
    </div>

    <div class="section section-contact-us text-center">
        <div class="container">
            <h2 class="title">Want to work with us?</h2>
            <p class="description">Your project is very important to us. Place your enquiry.</p>
            <form id="contactForm">
                <div class="row">
                    <div class="col-lg-6 text-center col-md-8 m-auto">
                        <div class="input-group input-lg">
                            <input type="text" id="clientName" name="clientName" class="form-control" placeholder="Name...">
                        </div>
                        <div class="input-group input-lg">
                            <input type="text" id="clientContact" name="clientContact" class="form-control" placeholder="Contact...">
                        </div>
                        <div class="input-group input-lg">
                            <input type="text" id="enquiryLocation" name="enquiryLocation" class="form-control" placeholder="Location...">
                        </div>
                        <div class="input-group input-lg">
                            <select class="form-select" id="packageId" name="packageId">
                            </select>
                        </div>
                        <div class="input-group input-lg">
                            <input type="date" id="enquiryDate" name="enquiryDate" class="form-control" placeholder="Date...">
                        </div>
                        <div class="textarea-container">
                            <textarea class="form-control" name="message" id="message" rows="4" cols="80" placeholder="Type a message..."></textarea>
                        </div>
                        <div class="send-button">
                            <input type="hidden" id="action" name="action" value="addNew">
                            <input type="submit" name="submit" class="btn btn-primary btn-round btn-block btn-lg enquiryBtn" value="Send Enquiry" />
                        </div>
                    </div>
                </div>
            </form>
            <div class="statusMsg"></div>
        </div>
    </div>

    <?php
    include('./components/footer-copyright.php');
    include('./components/external-js.php');
    ?>
    <script>
        function sendEnquiry() {
            $("#contactForm").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: './controllers/enquiry_controller.php',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.enquiryBtn').attr("disabled", "disabled");
                        $('#contactForm').css("opacity", ".5");
                    },
                    success: function(response) {
                        console.log(response);
                        $('.statusMsg').html('');
                        if (response.statusCode == 200) {
                            $('#contactForm')[0].reset();
                            $('.statusMsg').html('<p class="alert alert-success">Enquiry send success</p>');
                        } else {
                            $('.statusMsg').html('<p class="alert alert-danger">Enquiry send failed</p>');
                        }
                        $('#contactForm')[0].reset();
                        $('#contactForm').css("opacity", "");
                        $(".enquiryBtn").removeAttr("disabled");
                        // $('.statusMsg').html('');
                    }
                });
            });
        }

        function listPackages() {
            $.ajax({
                url: "./controllers/package_controller.php",
                type: "POST",
                cache: false,
                data: {
                    action: 'listPackage'
                },
                success: function(data) {
                    $('#packageId').html(data);
                }
            });
        }

        $(document).ready(function() {

            sendEnquiry();
            listPackages();

            var home = $('#homeClientBtn').parent();
            var service = $('#serviceClientBtn').parent();
            var gallery = $('#galleryClientBtn').parent();
            var about = $('#aboutClientBtn').parent();

            home.removeClass('active');
            service.removeClass('active');
            gallery.removeClass('active');
            about.removeClass('active');
        });
    </script>

</body>

</html>