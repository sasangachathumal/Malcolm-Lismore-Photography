<?php
session_start();
if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === true && isset($_SESSION['userId'])) {
    include('./components/head.php');
    $active = 'gallery';
?>

    <body>

        <?php include('./components/admin_navi.php'); ?>

        <div class="container-fluid">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid">
            <div class="row" style="padding-right: 15px; padding-left: 15px;">
                <div class="col-md-10 d-flex align-items-center">
                    <h2 class="float-left" style="margin: 0;">Manage Gallery</h2>
                </div>
                <div class="col-md-2 align-self-end" style="padding: 0;">
                    <button type="button" id="newUpload" class="btn btn-primary float-right" data-id="0">
                        <i class="fa-solid fa-plus"></i> Upload
                    </button>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="row row-cols-1 row-cols-md-4 g-4" id="galleryContainer">
                <div class="col mb-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Wedding Photography</h5>
                            <button class="btn btn-warning btn-icon top-bottom-margin-0">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-icon top-bottom-margin-0">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-labelledby="Upload Image Modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Upload A New Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="uploadForm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="newImgTitle">Image Title</label>
                                        <input class="form-control" type="text" id="newImgTitle" name="newImgTitle">
                                        <datalist id="uploadNameList"></datalist>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="newFile" class="form-label">Select Image</label>
                                        <input class="form-control" type="file" id="newFile" name="newFile" required>
                                    </div>
                                </div>
                                <input type="hidden" id="action" name="action" value="addNew">
                                <input type="submit" name="submit" class="btn btn-primary submitBtn" value="UPLOAD" />
                            </form>
                            <div class="statusMsg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewUploadImage" tabindex="-1" role="dialog" aria-labelledby="Upload Image View Modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Update Image Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="editForm">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="imgTitle">Image Title</label>
                                        <input class="form-control" type="text" id="imgTitle" name="imgTitle">
                                        <datalist id="updateNameList"></datalist>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="selectedImg" class="form-label">Uploaded Image</label>
                                        <img src="" id="selectedImg" />
                                    </div>
                                </div>
                                <input type="hidden" id="action" name="action" value="update">
                                <input type="hidden" id="id" name="id" value="">
                                <input type="submit" name="submit" class="btn btn-primary updateBtn" value="UPDATE" />
                            </form>
                            <div class="statusMsg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include('./components/footer-copyright.php');
        include('./components/external-js.php');
        ?>

        <script>
            var uploadImage = new bootstrap.Modal('#uploadImage', {
                backdrop: 'static'
            });

            var viewUploadImage = new bootstrap.Modal('#viewUploadImage', {
                backdrop: 'static'
            });

            function viewImagesList() {
                $.ajax({
                    url: "./controllers/gallery_controller.php",
                    type: "POST",
                    cache: false,
                    data: {
                        action: 'viewList'
                    },
                    success: function(data) {
                        $('#galleryContainer').html(data);
                    }
                });
            }

            function deleteImage() {
                $(document).on("click", "#btnDeleteImg", function() {
                    const message = 'Are you sure you want to Delete this Gallery Image !';
                    if (confirm(message) == true) {
                        var $ele = $(this).parent().parent();
                        $.ajax({
                            url: "./controllers/gallery_controller.php",
                            type: "POST",
                            cache: false,
                            data: {
                                action: 'delete',
                                id: $(this).attr("data-id")
                            },
                            success: function(dataResult) {
                                var dataResult = JSON.parse(dataResult);
                                if (dataResult.statusCode == 200) {
                                    $ele.fadeOut().remove();
                                }
                            }
                        });
                    }
                });
            }

            function openImageDetailPopup() {
                $(document).on("click", "#btnViewImg", function() {
                    $.ajax({
                        url: "./controllers/gallery_controller.php",
                        type: "POST",
                        cache: false,
                        data: {
                            action: 'viewSignle',
                            id: $(this).attr("data-id")
                        },
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);

                            $('#imgTitle').val(dataResult.imgTitle);
                            $('#selectedImg').attr("src", dataResult.imgUrl);
                            $('#id').val(dataResult.id);
                        }
                    });
                    viewUploadImage.show();
                });
            }

            function updateClick() {
                $("#editForm").on('submit', function(e) {
                    const message = 'Are you sure you want to Update this Image details !';
                    if (confirm(message) == true) {
                        $.ajax({
                            type: 'POST',
                            url: './controllers/gallery_controller.php',
                            data: new FormData(this),
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function() {
                                $('.updateBtn').attr("disabled", "disabled");
                                $('#editForm').css("opacity", ".5");
                            },
                            success: function(response) {
                                console.log(response);
                                $('.statusMsg').html('');
                                if (response.statusCode == 200) {
                                    $('#editForm')[0].reset();
                                    $('.statusMsg').html('<p class="alert alert-success">Image detail update success</p>');
                                } else {
                                    $('.statusMsg').html('<p class="alert alert-danger">Image detail update failed</p>');
                                }
                                $('#editForm')[0].reset();
                                $('#editForm').css("opacity", "");
                                $(".updateBtn").removeAttr("disabled");
                                $('.statusMsg').html('');
                                viewImagesList();
                                viewUploadImage.hide();
                            }
                        });
                    }
                });
            }

            function newImageBtnClick() {
                $(document).on("click", "#newUpload", function() {
                    uploadImage.show();
                });
            }

            function saveNewImage() {
                $("#uploadForm").on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: './controllers/gallery_controller.php',
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('.submitBtn').attr("disabled", "disabled");
                            $('#uploadForm').css("opacity", ".5");
                        },
                        success: function(response) {
                            console.log(response);
                            $('.statusMsg').html('');
                            if (response.statusCode == 200) {
                                $('#uploadForm')[0].reset();
                                $('.statusMsg').html('<p class="alert alert-success">Image upload success</p>');
                            } else {
                                $('.statusMsg').html('<p class="alert alert-danger">Image upload failed</p>');
                            }
                            $('#uploadForm')[0].reset();
                            $('#uploadForm').css("opacity", "");
                            $(".submitBtn").removeAttr("disabled");
                            $('.statusMsg').html('');
                            viewImagesList();
                            uploadImage.hide();
                        }
                    });
                });
            }

            $(document).ready(function() {
                viewImagesList();
                deleteImage();
                openImageDetailPopup();
                updateClick();
                newImageBtnClick();
                saveNewImage();

                // File type validation
                $("#newFile").change(function() {
                    var file = this.files[0];
                    var fileType = file.type;
                    var match = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))) {
                        alert('Sorry, only JPG, JPEG, & PNG files are allowed to upload.');
                        $("#newFile").val('');
                        return false;
                    }
                });
            });
        </script>

    </body>

    </html>
<?php } ?>