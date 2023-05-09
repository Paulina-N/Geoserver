<?php
// include $_SERVER['DOCUMENT_ROOT'] . '/map_pwd.php';

//Heroku ClearDB connection
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;

$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

// local server
// $serverName = "localhost";
// $dBUserName = "map";
// $dBPassword = $DBPWD;
// $dBName = "map";

// $conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    if (isset($_SESSION["useremail"])) {
        $email = $_SESSION["useremail"];
        $sql = "SELECT * FROM users WHERE usersEmail = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $userID = $row['usersId'];
            $firstName = $row['usersFirstName'];
            $lastName = $row['usersLastName'];
            $companyID = $row['companyId'];
            $profileImage = $row['profileImg'];

            $sql = "SELECT name, admin FROM companies WHERE id = '$companyID';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $companyName = $row['name'];
                $adminID = $row['admin'];
            } else {
                $adminID = 0;
                $companyID = 0;
            }
        }

        if ($profileImage == null) {
            $profileImage = "profiledefault.jpg";
        }

        $sqlGroups = "SELECT * FROM groups WHERE companyId='$companyID'";
        $groupsResult = mysqli_query($conn, $sqlGroups);
        while ($row = mysqli_fetch_array($groupsResult)) {
            $groupResult[$row['id']] = $row['name'];
        }

        $allLayersUrls = array();
        $allLayersTitles = array();
        $allLayersNames = array();
        $sqlLayers = "SELECT * FROM layers WHERE companyId='$companyID'";
        $layersResult = mysqli_query($conn, $sqlLayers);
        while ($row = mysqli_fetch_array($layersResult)) {
            $layerUrl = $row['url'];
			array_push($allLayersUrls, $layerUrl);
            $layerTitle = $row['title'];
			array_push($allLayersTitles, $layerTitle);
            $layername = $row['name'];
			array_push($allLayersNames, $layername);
        }
        $layersResult = mysqli_query($conn, $sqlLayers);
    }
}
