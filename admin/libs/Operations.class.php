<?php

class Operations
{
    public static function setBlogs($img, $title, $owner, $dt, $cate, $intro, $content)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/blogs/"; // Define upload directory
        
        // Create directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate and upload image
        $fileName = basename($img["name"]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $filePath = $targetDir . uniqid() . '.' . $fileType; // Unique file name

        if (!in_array($fileType, $allowedTypes)) {
            return "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
        }

        if (!move_uploaded_file($img["tmp_name"], $filePath)) {
            return "Error: Failed to upload the image.";
        }

        // Escape special characters to prevent SQL injection
        $filePath = $conn->real_escape_string($filePath);
        $content = $conn->real_escape_string($content);

        // Insert into database (Prepared statement for security)
        $sql = "INSERT INTO `blogs` (`img`, `title`, `owner`, `date`, `category`, `dec`, `content`, `created_at`) VALUES ('$filePath', '$title', '$owner', '$dt', '$cate', '$intro', '$content', NOW())";
        
        if ($conn->query($sql)) {
            header("Location: viewBlogs.php");
            exit;
        } else {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setSliders($img, $cate)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/sliders/"; // Define upload directory

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Create directory if not exists
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];
        $imagePaths = [];

        // Check if multiple files are uploaded
        if (is_array($_FILES["img"]["name"])) {
            foreach ($_FILES["img"]["name"] as $key => $fileName) {
                $fileTmp = $_FILES["img"]["tmp_name"][$key];
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                if (in_array($fileType, $allowTypes)) {
                    $newFileName = time() . "_" . $fileName; // Unique file name
                    $filePath = $targetDir . $newFileName;

                    if (move_uploaded_file($fileTmp, $filePath)) {
                        $imagePaths[] = $filePath; // Store file path
                    }
                }
            }
        }

        if (empty($imagePaths)) {
            return "Error uploading files.";
        }

        // Convert image paths array into a comma-separated string
        $imgPathsStr = implode(",", $imagePaths);

        // Insert data into database
        $sql = "INSERT INTO `sliders` (`img`, `category`, `created_at`) VALUES ('$imgPathsStr', '$cate', NOW())";

        if ($conn->query($sql)) {
            header("Location: viewSliders.php");
            exit;
        } else {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setTest($img, $cate)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/test/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `test` (`img`, `created_at`, `category`) VALUES ('$img', NOW(), '$cate')";

        if ($conn->query($sql))
        {
            header("Location: viewTest.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setMind($img)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/mind/"; // Define your upload directory

        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Handle multiple file uploads
        if (!empty($_FILES['img']['name'][0])) {
            foreach ($_FILES['img']['name'] as $key => $fileName) {
                // Check if file is uploaded
                if ($_FILES['img']['error'][$key] == 0) {
                    $fileTmpName = $_FILES['img']['tmp_name'][$key];
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                    // Validate file type
                    if (in_array($fileType, $allowTypes)) {
                        // Move the uploaded file to the target directory
                        $filePath = $targetDir . basename($fileName);
                        if (move_uploaded_file($fileTmpName, $filePath)) {
                            // Insert data into database for each file
                            $sql = "INSERT INTO `mind` (`img`, `created_at`) VALUES ('$filePath', NOW())";
                            if (!$conn->query($sql)) {
                                return "Error occurred while saving data: " . $conn->error;
                            }
                        } else {
                            return "Error uploading file: $fileName";
                        }
                    } else {
                        return "File type not allowed: $fileName";
                    }
                } else {
                    return "Error with file upload: $fileName";
                }
            }

            // Redirect after all files are uploaded and saved
            header("Location: viewMind.php");
            exit;
        } else {
            return "No files selected for upload.";
        }
    }

    public static function setMLS($img)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/mlsg/"; // Define your upload directory

        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Handle multiple file uploads
        if (!empty($_FILES['img']['name'][0])) {
            foreach ($_FILES['img']['name'] as $key => $fileName) {
                // Check if file is uploaded
                if ($_FILES['img']['error'][$key] == 0) {
                    $fileTmpName = $_FILES['img']['tmp_name'][$key];
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                    // Validate file type
                    if (in_array($fileType, $allowTypes)) {
                        // Move the uploaded file to the target directory
                        $filePath = $targetDir . basename($fileName);
                        if (move_uploaded_file($fileTmpName, $filePath)) {
                            // Insert data into database for each file
                            $sql = "INSERT INTO `mls` (`img`, `created_at`) VALUES ('$filePath', NOW())";
                            if (!$conn->query($sql)) {
                                return "Error occurred while saving data: " . $conn->error;
                            }
                        } else {
                            return "Error uploading file: $fileName";
                        }
                    } else {
                        return "File type not allowed: $fileName";
                    }
                } else {
                    return "Error with file upload: $fileName";
                }
            }

            // Redirect after all files are uploaded and saved
            header("Location: viewMLSG.php");
            exit;
        } else {
            return "No files selected for upload.";
        }
    }

    public static function setImages($img, $cate)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/"; // Define upload directory

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Create directory if not exists
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];
        $imagePaths = [];

        // Check if multiple files are uploaded
        if (is_array($_FILES["img"]["name"])) {
            foreach ($_FILES["img"]["name"] as $key => $fileName) {
                $fileTmp = $_FILES["img"]["tmp_name"][$key];
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                if (in_array($fileType, $allowTypes)) {
                    $newFileName = time() . "_" . $fileName; // Unique file name
                    $filePath = $targetDir . $newFileName;

                    if (move_uploaded_file($fileTmp, $filePath)) {
                        $imagePaths[] = $filePath; // Store file path
                    }
                }
            }
        }

        if (empty($imagePaths)) {
            return "Error uploading files.";
        }

        // Convert image paths array into a comma-separated string
        $imgPathsStr = implode(",", $imagePaths);

        // Insert data into database
        $sql = "INSERT INTO `images` (`img`, `category`, `created_at`) VALUES ('$imgPathsStr', '$cate', NOW())";

        if ($conn->query($sql)) {
            header("Location: viewImages.php");
            exit;
        } else {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setAadheeHeader($header, $img)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/aadhee/sub/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `aadheeheader` (`title`, `img`, `created_at`) VALUES ('$header', '$img', NOW())";

        if ($conn->query($sql))
        {
            header("Location: viewAadhee.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setAadhee($title, $img, $price, $cate)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/aadhee/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `aadhee` (`title`, `img`, `price`, `uploaded_time`, `category`) 
                VALUES ('$title', '$img', '$price', now(), '$cate')";

        if ($conn->query($sql))
        {
            header("Location: viewAadhee.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setIndeeHeader($header, $img)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/indee/sub/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `indeeheader` (`title`, `img`, `created_at`) VALUES ('$header', '$img', NOW())";

        if ($conn->query($sql))
        {
            header("Location: viewIndee.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setIndee($title, $img, $price, $cate)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/indee/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `indee` (`title`, `img`, `price`, `uploaded_time`, `category`) 
                VALUES ('$title', '$img', '$price', now(), '$cate')";

        if ($conn->query($sql))
        {
            header("Location: viewIndee.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setSpatiality($title, $img, $dec)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/spatiality/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `spatiality` (`title`, `img`, `dec`, `uploaded_time`) 
                VALUES ('$title', '$img', '$dec', now())";

        if ($conn->query($sql))
        {
            header("Location: viewSpatiality.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setInfo($sptitle, $img, $title, $dec, $vid)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/info/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `info` (`sp_title`, `img`, `title`, `dec`, `uploaded_time`, `vid`) 
                VALUES ('$sptitle', '$img', '$title', '$dec', now(), '$vid')";

        if ($conn->query($sql))
        {
            header("Location: viewInfo.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setLifeHeader($header, $img)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/lifestyle/sub/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `lifeheader` (`header`, `created_at`, `img`) VALUES ('$header', now(), '$img')";

        if ($conn->query($sql))
        {
            header("Location: viewLifestyle.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setLifeStyle($title, $img, $point)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/lifestyle/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file)
        {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowTypes) || !move_uploaded_file($file["tmp_name"], $filePath))
            {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `lifestyle` (`title`, `img`, `points`, `uploaded_time`) 
                VALUES ('$title', '$img', '$point', now())";

        if ($conn->query($sql))
        {
            header("Location: viewLifestyle.php");
            exit;
        }
        else
        {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setWorkshopsHeader($head)
    {
        $conn = Database::getConnect();
        // Insert data into database
        $sql = "INSERT INTO `workshop_header` (`head`, `created_at`) 
                VALUES ('$head', now())";

        if ($conn->query($sql)) {
            header("Location: addWorkshops.php");
            exit;
        } else {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setCards($header, $img, $cate)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/cards/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowImageTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file) {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            
            if (!in_array($fileType, $allowImageTypes) || !move_uploaded_file($file["tmp_name"], $filePath)) {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        $randomCode = substr(base64_encode(random_bytes(6)), 0, 8); // 8-character random code

        // Insert data into database
        $sql = "INSERT INTO `card` (`header`, `img`, `category`, `code`, `created_at`) 
                VALUES ('$header', '$img', '$cate', '$randomCode', now())";

        if ($conn->query($sql)) {
            header("Location: addWorkshops.php");
            exit;
        } else {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setWorkshops($title, $dec, $img, $vid, $cate, $cate2)
    {
        $conn = Database::getConnect();
        $targetDir = "../uploads/workshops/"; // Define your upload directory
        
        if (!is_dir($targetDir)) {
            // Create directory with proper permissions
            mkdir($targetDir, 0777, true);
        }

        $allowImageTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Required file uploads
        $requiredFiles = [
            'img' => $_FILES["img"]
        ];

        foreach ($requiredFiles as $key => $file) {
            $fileName = basename($file["name"]);
            $filePath = $targetDir . $fileName;
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            
            if (!in_array($fileType, $allowImageTypes) || !move_uploaded_file($file["tmp_name"], $filePath)) {
                return "Error uploading required file: $key.";
            }
            $$key = $filePath; // Dynamically assign variable with directory
        }

        // Insert data into database
        $sql = "INSERT INTO `workshops` (`title`, `dec`, `img`, `vid`, `created_at`, `category`, `category2`) 
                VALUES ('$title', '$dec', '$img', '$vid', now(), '$cate', '$cate2')";

        if ($conn->query($sql)) {
            header("Location: viewWorkshops.php");
            exit;
        } else {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function setLive($link, $se, $title)
    {
        $conn = Database::getConnect();
        // Insert data into database
        $code = substr(base64_encode(random_bytes(6)), 0, 8); // 8-character random code
        $sql = "INSERT INTO `live` (`link`, `st_et`, `created_at`, `title`, `code`) VALUES ('$link', '$se', now(), '$title', '$code')";

        if ($conn->query($sql)) {
            header("Location: viewLive.php");
            exit;
        } else {
            return "Error occurred while saving data: " . $conn->error;
        }
    }

    public static function getBlogs()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `blogs` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getSliders()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `sliders` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getTest()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `test` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getMind()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `mind` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getMLS()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `mls` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getImages()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `images` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getAadheeHeader()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `aadheeheader` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getAadhee()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `aadhee` ORDER BY `uploaded_time` DESC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getIndeeHeader()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `indeeheader` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getIndee()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `indee` ORDER BY `uploaded_time` DESC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getSpatiality()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `spatiality` ORDER BY `id`";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getInfo()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `info` ORDER BY `uploaded_time` DESC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getLifeHeader()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `lifeheader` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getLifeStyle()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `lifestyle` ORDER BY `uploaded_time` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getWorkshops($conn)
    {
        // $conn = Database::getConnect();
        $sql = "SELECT * FROM `workshops` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getWorkshopsCard($conn)
    {
        // $conn = Database::getConnect();
        $sql = "SELECT * FROM `card` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getLive()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `live` ORDER BY `created_at` DESC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getUser()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `user` ORDER BY `created_at` DESC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getWorkshopsHeader($conn)
    {
        // $conn = Database::getConnect();
        $sql = "SELECT * FROM `workshop_header` ORDER BY `created_at` DESC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }

    public static function getBlog()
    {
        $getID = $_GET['data'];
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `blogs` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getBloger($conn)
    {
        $getID = (int)$_GET['edit_id'];
        $sql = "SELECT * FROM `blogs` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProAadhee($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `aadhee` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProIndee($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `Indee` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProSpatiality($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `spatiality` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProInfo($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `info` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProLifestyle($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `lifestyle` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProWorkshops($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `workshops` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProCard($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `card` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProLive($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `live` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProUser($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `user` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getWorkshopHeader($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `workshop_header` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getWH($conn)
    {
        $sql = "SELECT * FROM `workshop_header` ORDER BY `created_at` DESC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
}

?>