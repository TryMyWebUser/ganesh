<?php
    include "../libs/load.php";

    // Start a session
    Session::start();

    if (!Session::get('login_user')) {
        header("Location: index.php");
        exit;
    }

    $conn = Database::getConnect();
    $products = Operations::getProductChecker($conn);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>View - Products</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <?php include "temp/head.php"; ?>
    </head>

    <body>
        <div class="container-xxl position-relative bg-white d-flex p-0">
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->

            <!-- Sidebar Start -->
            <?php include "temp/sideheader.php"; ?>
            <!-- Sidebar End -->

            <!-- Content Start -->
            <div class="content">
                <!-- Navbar Start -->
                <?php include "temp/header.php"; ?>
                <!-- Navbar End -->

                <!-- Table Start -->
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="bg-light rounded h-100 p-4">
                                <h6 class="mb-4">Packers & Movers Page Table</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Category</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($products)) {
                                                foreach ($products as $pro) {
                                                    $category = $pro['category'];
                                                    $qry = "SELECT * FROM `category` WHERE `category` = '$category'";
                                                    $result = $conn->query($qry);
                                                    $row = $result ? $result->fetch_assoc() : null;
                                                    if ($row && $row['page'] === 'p&m') {
                                            ?>
                                                        <tr scope="row">
                                                            <td><?= $pro['category']; ?></td>
                                                            <td><img src="<?= $pro['img']; ?>" style="width: 4rem;" alt="Image Not Found"></td>
                                                            <td><?= $pro['title']; ?></td>
                                                            <td><?= $pro['dec']; ?></td>
                                                            <td>
                                                                <a href="editProduct.php?edit_id=<?= $pro['id']; ?>">
                                                                    <button type="button" class="btn btn-square btn-outline-info m-2"><i class="fa fa-pen"></i></button>
                                                                </a>
                                                                <a href="deletePro.php?delete_id=<?= $pro['id']; ?>">
                                                                    <button type="button" class="btn btn-square btn-outline-danger m-2"><i class="fa fa-trash"></i></button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    } else {
                                                        echo "<tr><td colspan='5'>No Data Found</td></tr>";
                                                    }
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No Data Found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" style="padding-bottom: 5rem;">
                            <div class="bg-light rounded h-100 p-4">
                                <h6 class="mb-4">Service Page Table</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Category</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($products)) {
                                                foreach ($products as $pro) {
                                                    $category = $pro['category'];
                                                    $qry = "SELECT * FROM `category` WHERE `category` = '$category'";
                                                    $result = $conn->query($qry);
                                                    $row = $result ? $result->fetch_assoc() : null;
                                                    if ($row && $row['page'] === 'service') {
                                            ?>
                                                        <tr scope="row">
                                                            <td><?= $pro['category']; ?></td>
                                                            <td><img src="<?= $pro['img']; ?>" style="width: 4rem;" alt="Image Not Found"></td>
                                                            <td><?= $pro['title']; ?></td>
                                                            <td><?= $pro['dec']; ?></td>
                                                            <td>
                                                                <a href="editProduct.php?edit_id=<?= $pro['id']; ?>">
                                                                    <button type="button" class="btn btn-square btn-outline-info m-2"><i class="fa fa-pen"></i></button>
                                                                </a>
                                                                <a href="deletePro.php?delete_id=<?= $pro['id']; ?>">
                                                                    <button type="button" class="btn btn-square btn-outline-danger m-2"><i class="fa fa-trash"></i></button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    } else {
                                                        echo "<tr><td colspan='5'>No Data Found</td></tr>";
                                                    }
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No Data Found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table End -->

                <!-- Footer Start -->
                <div class="container-fluid p-0 position-fixed bottom-0">
                    <div class="bg-light rounded-top p-4">
                        <div class="row">
                            <div class="col-12 col-sm-6 text-center text-sm-end">
                                Designed & Developed By <a class="border-bottom" href="https://trymywebsites.com" target="_blank">Trymywebsites</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer End -->
            </div>
            <!-- Content End -->

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <?php include "temp/footer.php"; ?>
    </body>

</html>