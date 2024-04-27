<?php
session_start();
if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === true && isset($_SESSION['userId'])) {
    include('./components/head.php');
    $active = 'package';
?>

    <body>

        <?php include('./components/admin_navi.php'); ?>

        <div class="container-fluid">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Packages</li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid">
            <div class="row" style="padding-right: 15px; padding-left: 15px;">
                <div class="col-md-8 d-flex align-items-center">
                    <h2 class="float-left" style="margin: 0;">Manage Photography Packages</h2>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4" style="padding: 0;">
                            <button type="button" id="newPackageBtn" class="btn btn-primary" data-id="0">
                                <i class="fa-solid fa-plus"></i> New Package
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped package-table">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">name</th>
                            <th scope="col">price</th>
                            <th scope="col action-col"></th>
                        </tr>
                    </thead>
                    <tbody id="packageTable">
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="packageViewModal" tabindex="-1" role="dialog" aria-labelledby="package View Modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Package Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="packageID">Package ID</label>
                                        <input class="form-control" type="text" id="packageID" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="packageName">Package Name</label>
                                        <input class="form-control" type="text" id="packageName">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="packagePrice">Package Price</label>
                                        <input class="form-control" type="text" id="packagePrice">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="packageInfo">Package Info</label>
                                        <textarea class="form-control" id="packageInfo" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="saveBtn" class="btn btn-success btn-block" data-id="0" data-status="1">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="packageCreateModal" tabindex="-1" role="dialog" aria-labelledby="package Create Modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add New Package</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="newPackageName">Package Name</label>
                                        <input class="form-control" type="text" id="newPackageName">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="packagePrice">Package Price</label>
                                        <input class="form-control" type="text" id="newPackagePrice">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="packageInfo">Package Info</label>
                                        <textarea class="form-control" id="newPackageInfo" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="saveNewBtn" class="btn btn-success btn-block">Save Package</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include('./components/footer-copyright.php');
        include('./components/external-js.php');
        ?>

        <script>
            // bootrtrap modals
            var packageViewModal = new bootstrap.Modal('#packageViewModal', {
                backdrop: 'static'
            });
            var packageCreateModal = new bootstrap.Modal('#packageCreateModal', {
                backdrop: 'static'
            });

            function clearFields() {
                $('#newPackageName').val('');
                $('#newPackagePrice').val('');
                $('#newPackageInfo').val('');
                $('#packageName').val(''),
                    $('#packagePrice').val(''),
                    $('#packageInfo').val('')
            }

            function viewPackages() {
                $.ajax({
                    url: "./controllers/package_controller.php",
                    type: "POST",
                    cache: false,
                    data: {
                        action: 'viewList'
                    },
                    success: function(data) {
                        $('#packageTable').html(data);
                    }
                });
            }

            function deletePackage() {
                $(document).on("click", "#packageDeleteBtn", function() {
                    const message = 'Are you sure you want to Delete this Package !';
                    if (confirm(message) == true) {
                        var $ele = $(this).parent().parent();
                        $.ajax({
                            url: "./controllers/package_controller.php",
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

            function updatePackage(id, updateData) {
                const data = Object.assign(updateData, {
                    action: 'update',
                    id: id
                });
                $.ajax({
                    url: "./controllers/package_controller.php",
                    type: "POST",
                    cache: false,
                    data: data,
                    success: function(dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            viewPackages();
                            clearFields();
                            packageViewModal.hide();
                        }
                    }
                });
            }

            function openPackageDetailPopup() {
                $(document).on("click", "#fullView", function() {
                    $.ajax({
                        url: "./controllers/package_controller.php",
                        type: "POST",
                        cache: false,
                        data: {
                            action: 'viewSignle',
                            id: $(this).attr("data-id")
                        },
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);

                            $('#packageID').val('PAC-' + dataResult.id);
                            $('#packageName').val(dataResult.packageName);
                            $('#packagePrice').val(dataResult.packagePrice);
                            $('#packageInfo').val(dataResult.packageInfo);

                            $('#saveBtn').attr("data-id", dataResult.id);
                        }
                    });
                    packageViewModal.show();
                });
            }

            function updateClick() {
                $(document).on("click", "#saveBtn", function() {
                    var packageName = $('#packageName').val();
                    var packagePrice = $('#packagePrice').val();
                    var packageInfo = $('#packageInfo').val();
                    if (!packageName.trim() || !packagePrice.trim() || packageInfo.trim()) {
                        alert('Required data missing!');
                    } else {
                        const message = 'Are you sure you want to Update this Package !';
                        if (confirm(message) == true) {
                            const updateData = {
                                packageName: packageName,
                                packagePrice: packagePrice,
                                packageInfo: packageInfo
                            }
                            updatePackage($(this).attr("data-id"), updateData);
                        }
                    }
                });
            }

            function newPackageBtnClick() {
                $(document).on("click", "#newPackageBtn", function() {
                    packageCreateModal.show();
                });
            }

            function saveNewPackage() {
                $(document).on("click", "#saveNewBtn", function() {
                    var packageName = $('#newPackageName').val();
                    var packagePrice = $('#newPackagePrice').val();
                    var packageInfo = $('#newPackageInfo').val();
                    if (!packageName.trim() || !packagePrice.trim() || packageInfo.trim()) {
                        alert('Required data missing!');
                    } else {
                        $.ajax({
                            url: "./controllers/package_controller.php",
                            type: "POST",
                            cache: false,
                            data: {
                                action: 'addNew',
                                packageName: packageName,
                                packagePrice: packagePrice,
                                packageInfo: packageInfo
                            },
                            success: function(dataResult) {
                                var dataResult = JSON.parse(dataResult);
                                if (dataResult.statusCode == 200) {
                                    viewPackages();
                                    clearFields();
                                    packageCreateModal.hide();
                                }
                            }
                        });
                    }
                });
            }

            $(document).ready(function() {
                viewPackages();
                deletePackage();
                openPackageDetailPopup();
                updateClick();
                newPackageBtnClick();
                saveNewPackage();
            });
        </script>

    </body>

    </html>

<?php } ?>