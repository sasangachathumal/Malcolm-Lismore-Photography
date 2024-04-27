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
        case 'listHome':
            imageListHome();
            break;
        case 'listGallery':
            imageListGallery();
            break;
        default:
            viewList();
            break;
    }
}

function update()
{
    $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');
    if (!isset($_POST['id']) && !isset($_POST['imgTitle'])) {
        echo json_encode(array("statusCode" => 500));
    } else {
        $imageId = $_POST['id'];
        $imgTitle = $_POST['imgTitle'];
        if ($dbConnection) {
            $updateQuery = "UPDATE gallery SET imgTitle='$imgTitle'  WHERE id='$imageId'";
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
        $galleryId = $_POST['id'];
        if ($dbConnection) {
            $getQuery = "SELECT * FROM gallery WHERE id='$galleryId'";
            $galleryImages = mysqli_query($dbConnection, $getQuery);
            if (mysqli_num_rows($galleryImages) > 0) {
                while ($image = mysqli_fetch_assoc($galleryImages)) {
                    echo json_encode($image);
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
        $getQuery = "SELECT * FROM gallery";
        $galleryImages = mysqli_query($dbConnection, $getQuery);
        if (mysqli_num_rows($galleryImages) > 0) {
            while ($image = mysqli_fetch_assoc($galleryImages)) {
                echo '<div class="col mb-4">
                <div class="card h-100">
                    <img src="' . $image['imgUrl'] . '" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">' . $image['imgTitle'] . '</h5>
                        <div class="py-6">
                            <button id="btnViewImg" data-id="' . $image['id'] . '" class="btn btn-warning btn-icon top-bottom-margin-0">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button id="btnDeleteImg" data-id="' . $image['id'] . '" class="btn btn-danger btn-icon top-bottom-margin-0">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
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
        $galleryId = $_POST['id'];
        $deleteQuery = "DELETE FROM gallery WHERE id='$galleryId'";
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

    $uploadDir = '../assets/uploads/';
    $saveDir = './assets/uploads/';

    // Allowed file types 
    $allowTypes = array('jpg', 'png', 'jpeg');

    if (isset($_POST['newImgTitle']) && isset($_FILES['newFile'])) {

        $uploadStatus = 1;

        // Upload file 
        $uploadedFile = '';
        if (!empty($_FILES["newFile"]["name"])) {
            // File path config 
            $fileName = basename($_FILES["newFile"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $saveFilePath = $saveDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats to upload 
            if (in_array($fileType, $allowTypes)) {
                // Upload file to the server 
                if (move_uploaded_file($_FILES["newFile"]["tmp_name"], $targetFilePath)) {
                    $uploadedFile = $fileName;
                } else {
                    $uploadStatus = 0;
                    $response['message'] = 'Sorry, there was an error uploading your file.';
                    echo json_encode($response);
                }
            } else {
                $uploadStatus = 0;
                $response['message'] = 'Sorry, only ' . implode('/', $allowTypes) . ' files are allowed to upload.';
                echo json_encode($response);
            }
        }
        if ($uploadStatus == 1) {
            $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

            $imgTitle = $_POST['newImgTitle'];
            $imgUrl = $saveFilePath;
            $userId = $_SESSION['userId'];

            $insertQuery = "INSERT INTO gallery(imgTitle,imgUrl,userId) values ('$imgTitle', '$imgUrl', '$userId')";

            if (mysqli_query($dbConnection, $insertQuery)) {
                echo json_encode(array("statusCode" => 200));
            } else {
                echo json_encode(array("statusCode" => 201));
            }
        }
    } else {
        echo json_encode(array("statusCode" => 500));
    }
}

function imageListHome()
{
    $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

    if ($dbConnection) {
        $getQuery = "SELECT * FROM `gallery` ORDER BY `id` DESC LIMIT 6";
        $galleryImages = mysqli_query($dbConnection, $getQuery);
        if (mysqli_num_rows($galleryImages) > 0) {
            $index = 0;
            while ($image = mysqli_fetch_assoc($galleryImages)) {
                if ($index == 0) {
                    echo '<div class="carousel-item active">
                    <img src="'.$image['imgUrl'].'" class="d-block w-100" alt="...">
                  </div>';
                } else {
                    echo '<div class="carousel-item">
                <img src="'.$image['imgUrl'].'" class="d-block w-100" alt="...">
              </div>';
                }
              $index++;
            }
        }
    } else {
        echo json_encode(array("statusCode" => 500));
    }
}

function imageListGallery()
{
    $dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

    if ($dbConnection) {
        $getQuery = "SELECT * FROM `gallery` ORDER BY `id` DESC";
        $galleryImages = mysqli_query($dbConnection, $getQuery);
        if (mysqli_num_rows($galleryImages) > 0) {
            while ($image = mysqli_fetch_assoc($galleryImages)) {
                echo '
                <div class="col mb-4">
                    <div class="card text-bg-dark">
                        <img src="'.$image['imgUrl'].'" class="card-img">
                        <div class="card-img-overlay">
                            <h5 class="card-title text-dark fw-bold">'.$image['imgTitle'].'</h5>
                        </div>
                    </div>
                </div>
                ';
            }
        }
    } else {
        echo json_encode(array("statusCode" => 500));
    }
}
