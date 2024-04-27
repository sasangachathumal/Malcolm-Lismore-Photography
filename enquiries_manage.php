<?php
session_start();
if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === true && isset($_SESSION['userId'])) {
    include('./components/head.php');
    $active = 'enquiry';
?>

    <body>

        <?php include('./components/admin_navi.php'); ?>

        <div class="container-fluid">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Enquiries</li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid">
            <h2>Manage Customer Enquiries</h2>
        </div>

        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped enquiry-table">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Category</th>
                            <th scope="col">Status</th>
                            <th scope="col">Enquiry Date</th>
                            <th scope="col">Location</th>
                            <th scope="col">Client Name</th>
                            <th scope="col action-col"></th>
                        </tr>
                    </thead>
                    <tbody id="enquiryTable">
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="enquiryViewModal" tabindex="-1" role="dialog" aria-labelledby="enquiry View Modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Enquiry Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enquiryID">Enquiry ID</label>
                                        <input class="form-control" type="text" id="enquiryID" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enquiryStatus">Enquiry Status</label>
                                        <input class="form-control" type="text" id="enquiryStatus" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enquiryCreated">Enquiry Created At</label>
                                        <input class="form-control" type="text" id="enquiryCreated" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enquiryDate">Enquiry Date</label>
                                        <input class="form-control" type="text" id="enquiryDate" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enquiryCategory">Enquiry Category</label>
                                        <input class="form-control" type="text" id="enquiryCategory" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enquiryLocation">Enquiry Location</label>
                                        <input class="form-control" type="text" id="enquiryLocation" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enquiryClientName">Client Name</label>
                                        <input class="form-control" type="text" id="enquiryClientName" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enquiryClientContact">Client Contact</label>
                                        <input class="form-control" type="text" id="enquiryClientContact" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="enquiryMessage">Message</label>
                                        <textarea class="form-control" id="enquiryMessage" rows="3" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="rejectBtn" class="btn btn-danger" data-id="0" data-status="2">Reject</button>
                        <button type="button" id="approveBtn" class="btn btn-success btn-block" data-id="0" data-status="1">Approve</button>
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
            var enquiryViewModal = new bootstrap.Modal('#enquiryViewModal', {backdrop: 'static'})

            function viewEnquiries() {
                $.ajax({
                    url: "./controllers/enquiry_controller.php",
                    type: "POST",
                    cache: false,
                    data: {
                        action: 'viewList'
                    },
                    success: function(data) {
                        $('#enquiryTable').html(data);
                    }
                });
            }

            function deleteEnquiry() {
                $(document).on("click", "#enquiryDeleteBtn", function() {
                    const message = 'Are you sure you want to Delete this Enquiry !';
                    if (confirm(message) == true) {
                        var $ele = $(this).parent().parent();
                        $.ajax({
                            url: "./controllers/enquiry_controller.php",
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

            function updateEnquiry(id, status) {
                $.ajax({
                    url: "./controllers/enquiry_controller.php",
                    type: "POST",
                    cache: false,
                    data: {
                        action: 'update',
                        id: id,
                        status: status
                    },
                    success: function(dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            viewEnquiries();
                            enquiryViewModal.hide();
                        }
                    }
                });
            }

            function openEnquiryDetailPopup() {
                $(document).on("click", "#fullView", function() {
                    $.ajax({
                        url: "./controllers/enquiry_controller.php",
                        type: "POST",
                        cache: false,
                        data: {
                            action: 'viewSignle',
                            id: $(this).attr("data-id")
                        },
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);
                            var status = "Pending";
                            switch (dataResult.enquiryStatus) {
                                case 0:
                                    status = "Pending";
                                    break;
                                case 1:
                                    status = "Approved";
                                    break;
                                case 2:
                                    status = "Rejected";
                                    break;

                                default:
                                    status = "Pending";
                                    break;
                            }
                            $('#enquiryID').val('ENQ-' + dataResult.id);
                            $('#enquiryStatus').val(status);
                            $('#enquiryCreated').val(dataResult.createdAt);
                            $('#enquiryDate').val(dataResult.enquiryDate);
                            $('#enquiryCategory').val(dataResult.packageName);
                            $('#enquiryLocation').val(dataResult.enquiryLocation);
                            $('#enquiryClientName').val(dataResult.clientName);
                            $('#enquiryClientContact').val(dataResult.clientContact);
                            $('#enquiryMessage').val(dataResult.message);

                            $('#rejectBtn').attr("data-id", dataResult.id);
                            $('#approveBtn').attr("data-id", dataResult.id);
                        }
                    });
                    enquiryViewModal.show();
                });
            }

            $(document).ready(function() {
                viewEnquiries();
                deleteEnquiry();
                openEnquiryDetailPopup();

                $(document).on("click", "#rejectBtn", function() {
                    const message = 'Are you sure you want to Reject this Enquiry !';
                    if (confirm(message) == true) {
                        updateEnquiry($(this).attr("data-id"), $(this).attr("data-status"));
                    }
                });

                $(document).on("click", "#approveBtn", function() {
                    const message = 'Are you sure you want to Approve this Enquiry !';
                    if (confirm(message) == true) {
                        updateEnquiry($(this).attr("data-id"), $(this).attr("data-status"));
                    }
                });
            });
        </script>

    </body>

    </html>
<?php } ?>