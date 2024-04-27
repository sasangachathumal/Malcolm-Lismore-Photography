<?php

session_start();

if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'delete':
			delete();
			break;
		case 'viewList':
			viewList();
			break;
		case 'viewSignle':
			viewSignle();
			break;
		case 'update':
			update();
			break;
		case 'addNew':
			addNew();
			break;
		default:
			viewList();
			break;
	}
}

function update()
{
	$dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');
	if (!isset($_POST['id']) || !isset($_POST['status'])) {
		echo json_encode(array("statusCode" => 500));
	} else {
		$enquiryId = $_POST['id'];
		$enquiryStatus = $_POST['status'];
		$userId = $_SESSION['userId'];
		if ($dbConnection) {
			$updateQuery = "UPDATE enquiry SET enquiryStatus='$enquiryStatus',userId='$userId' WHERE id='$enquiryId'";
			if (mysqli_query($dbConnection, $updateQuery)) {
				echo json_encode(array("statusCode" => 200));
			} else {
				echo json_encode(array("statusCode" => 201));
			}
		} else {
			echo json_encode(array("statusCode" => 500));
		}
	}
}

function viewSignle()
{
	$dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');
	if (!isset($_POST['id'])) {
		echo json_encode(array("statusCode" => 500));
	} else {
		$enquiryId = $_POST['id'];
		if ($dbConnection) {
			$getQuery = "SELECT * FROM enquiry WHERE id='$enquiryId'";
			$customerEnquiry = mysqli_query($dbConnection, $getQuery);
			if (mysqli_num_rows($customerEnquiry) > 0) {
				while ($enquiry = mysqli_fetch_assoc($customerEnquiry)) {
					$packageId = $enquiry['packageId'];
					$getPackageQuery = "SELECT * FROM package WHERE id='$packageId'";
					$packageList = mysqli_query($dbConnection, $getPackageQuery);
					if (mysqli_num_rows($packageList) > 0) {
						while ($package = mysqli_fetch_assoc($packageList)) {
							$enquiry['packageName'] = $package['packageName'];
							echo json_encode($enquiry);
						}
					}
				}
			}
		} else {
			echo json_encode(array("statusCode" => 500));
		}
	}
}

function viewList()
{
	$dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

	if ($dbConnection) {
		$getQuery = "SELECT * FROM enquiry ORDER BY createdAt DESC";
		$customerEnquiries = mysqli_query($dbConnection, $getQuery);
		if (mysqli_num_rows($customerEnquiries) > 0) {
			while ($enquiry = mysqli_fetch_assoc($customerEnquiries)) {
				$packageId = $enquiry['packageId'];
				$getPackageQuery = "SELECT * FROM package WHERE id='$packageId'";
				$packageList = mysqli_query($dbConnection, $getPackageQuery);
				if (mysqli_num_rows($packageList) > 0) {
					while ($package = mysqli_fetch_assoc($packageList)) {
						$status = "pending";
						switch ($enquiry['enquiryStatus']) {
							case 0:
								$status = "pending";
								break;
							case 1:
								$status = "approved";
								break;
							case 2:
								$status = "rejected";
								break;

							default:
								$status = "pending";
								break;
						}
						echo '
				<tr>
					<td scope="row">ENQ-' . $enquiry['id'] . '</td>
					<td scope="row">' . $package['packageName'] . '</td>
					<td scope="row" class="' . $status . '">' . $status . '</td>
					<td scope="row">' . $enquiry['enquiryDate'] . '</td>
					<td scope="row">' . $enquiry['enquiryLocation'] . '</td>
					<td scope="row">' . $enquiry['clientName'] . '</td>
					<td>
						<button id="fullView" data-id="' . $enquiry['id'] . '" class="btn btn-warning btn-icon btn-round top-bottom-margin-0">
							<i class="fa-solid fa-eye"></i>
						</button>
						<button id="enquiryDeleteBtn" data-id="' . $enquiry['id'] . '" class="btn btn-danger btn-icon btn-round top-bottom-margin-0">
							<i class="fa-solid fa-trash"></i>
						</button>
					</td>
				</tr>';
					}
				}
			}
		}
	} else {
		echo json_encode(array("statusCode" => 500));
	}
}

function delete()
{
	$dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');
	if (isset($_POST['id'])) {
		$enquiryId = $_POST['id'];
		$deleteQuery = "DELETE FROM enquiry WHERE id='$enquiryId'";
		if (mysqli_query($dbConnection, $deleteQuery)) {
			echo json_encode(array("statusCode" => 200));
		} else {
			echo json_encode(array("statusCode" => 201));
		}
	} else {
		echo json_encode(array("statusCode" => 500));
	}
}

function addNew()
{
	$dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

	if (
		isset($_POST['enquiryDate']) && isset($_POST['enquiryLocation']) && isset($_POST['packageId']) && isset($_POST['clientName']) &&
		isset($_POST['clientContact']) && isset($_POST['message'])
	) {
		$enquiryDate = $_POST['enquiryDate'];
		$enquiryLocation = $_POST['enquiryLocation'];
		$packageId = $_POST['packageId'];
		$clientName = $_POST['clientName'];
		$clientContact = $_POST['clientContact'];
		$message = $_POST['message'];

		$insertQuery = "INSERT INTO enquiry(enquiryDate,enquiryLocation,packageId,clientName,clientContact,message,enquiryStatus,createdAt)
		 values ('$enquiryDate', '$enquiryLocation', '$packageId', '$clientName', '$clientContact','$message','0',(now()))";
		// echo($insertQuery);
		if (mysqli_query($dbConnection, $insertQuery)) {
			echo json_encode(array("statusCode" => 200));
		} else {
			echo json_encode(array("statusCode" => 201));
		}
	} else {
		echo json_encode(array("statusCode" => 500));
	}
}
