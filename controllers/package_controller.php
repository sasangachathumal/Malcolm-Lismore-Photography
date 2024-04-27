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
        case 'getNameList':
            getNameList();
            break;
        case 'listHome':
            imageListHome();
            break;
        case 'listPackage':
            packageListGallery();
            break;
        default:
            viewList();
            break;
    }
}

function update()
{
    $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');
    if (!isset($_POST['id']) && !isset($_POST['packageName']) && !isset($_POST['packagePrice']) && !isset($_POST['packageInfo'])) {
        echo json_encode(array("statusCode" => 500));
    } else {
        $packageId = $_POST['id'];
        $packageName = $_POST['packageName'];
        $packagePrice = $_POST['packagePrice'];
        $packageInfo = mysqli_escape_string($dbConnection, $_POST['packageInfo']);
        if ($dbConnection) {
            $updateQuery = "UPDATE package SET packageName='$packageName',packagePrice='$packagePrice',packageInfo='$packageInfo'  WHERE id='$packageId'";
            // echo($updateQuery);
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
        $packageId = $_POST['id'];
        if ($dbConnection) {
            $getQuery = "SELECT * FROM package WHERE id='$packageId'";
            $packages = mysqli_query($dbConnection, $getQuery);
            if (mysqli_num_rows($packages) > 0) {
                while ($package = mysqli_fetch_assoc($packages)) {
                    echo json_encode($package);
                }
            }
        } else {
            echo json_encode(array("statusCode" => 500));
        }
    }
}

function getNameList()
{
    $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');
    if ($dbConnection) {
        $getQuery = "SELECT packageName FROM package";
        $packages = mysqli_query($dbConnection, $getQuery);
        if (mysqli_num_rows($packages) > 0) {
            while ($package = mysqli_fetch_assoc($packages)) {
                echo '<option value="' . $package['packageName'] . '">';
            }
        }
    } else {
        echo json_encode(array("statusCode" => 500));
    }
}

function viewList()
{
    $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

    if ($dbConnection) {
        $getQuery = "SELECT * FROM package";
        $packages = mysqli_query($dbConnection, $getQuery);
        if (mysqli_num_rows($packages) > 0) {
            while ($package = mysqli_fetch_assoc($packages)) {
                echo '
				<tr>
					<td scope="row">PAC-' . $package['id'] . '</td>
					<td scope="row">' . $package['packageName'] . '</td>
					<td scope="row">$ ' . $package['packagePrice'] . '</td>
					<td scope="row">
						<button id="fullView" data-id="' . $package['id'] . '" class="btn btn-warning btn-icon btn-round top-bottom-margin-0">
							<i class="fa-solid fa-eye"></i>
						</button>
						<button id="packageDeleteBtn" data-id="' . $package['id'] . '" class="btn btn-danger btn-icon btn-round top-bottom-margin-0">
							<i class="fa-solid fa-trash"></i>
						</button>
					</td>
				</tr>';
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
        $packageId = $_POST['id'];
        $deleteQuery = "DELETE FROM package WHERE id='$packageId'";
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

    if (isset($_POST['packageName']) && isset($_POST['packagePrice']) && isset($_POST['packageInfo'])) {
        $packageName = $_POST['packageName'];
        $packagePrice = $_POST['packagePrice'];
        $packageInfo = $_POST['packageInfo'];

        $insertQuery = "INSERT INTO package(packageName,packagePrice,packageInfo) values ('$packageName', '$packagePrice', '$packageInfo')";
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

function imageListHome()
{
    $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

    if ($dbConnection) {
        $getQuery = "SELECT * FROM `package` ORDER BY `id` DESC LIMIT 4";
        $packages = mysqli_query($dbConnection, $getQuery);
        if (mysqli_num_rows($packages) > 0) {
            while ($package = mysqli_fetch_assoc($packages)) {
                $imageUrl = '';
                switch ($package['packageName']) {
                    case 'Wedding Photography':
                        $imageUrl = "./assets/img/couple.png";
                        break;
                    case 'Portrait Photography':
                        $imageUrl = "./assets/img/portrait.png";
                        break;
                    case 'Event Photography':
                        $imageUrl = "./assets/img/event.png";
                        break;
                    default:
                        $imageUrl = '';
                        break;
                }
                echo '
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="package-image d-flex justify-content-center align-items-center">
                                <img src="' . $imageUrl . '">
                            </div>
                            <h3 class="card-title">' . $package['packageName'] . '</h3>
                            <h5 class="card-subtitle mb-2 text-body-secondary">$' . $package['packagePrice'] . '</h5>
                            <p class="card-text home-package-info">' . $package['packageInfo'] . '</p>
                        </div>
                    </div>
                </div>';
            }
        }
    } else {
        echo json_encode(array("statusCode" => 500));
    }
}

function packageListGallery()
{
    $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

    if ($dbConnection) {
        $getQuery = "SELECT id,packageName FROM `package` ORDER BY `id` DESC";
        $packageList = mysqli_query($dbConnection, $getQuery);
        if (mysqli_num_rows($packageList) > 0) {
            echo '<option value="0" selected>Select the package</option>';
            while ($package = mysqli_fetch_assoc($packageList)) {
                echo '
                    <option value="'.$package['id'].'">'.$package['packageName'].'</option>
                ';
                // echo json_encode($package);
            }
        }
    } else {
        echo json_encode(array("statusCode" => 500));
    }
}
