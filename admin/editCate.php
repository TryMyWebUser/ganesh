<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Add - Category</title>
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


                <!-- Form Start -->
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-6">
                            <div class="bg-light rounded h-100 p-4">
                                <h6 class="mb-4">Category Uploads</h6>
                                <form method="POST">
                                    <select class="form-select mb-3" name="page" required>
                                        <option>Select The Page</option>
                                        <option value="p&m">Packers & Movers Page</option>
                                        <option value="service">Service Page</option>
                                    </select>
                                    <div class="mb-3">
                                        <label class="form-label">Category?</label>
                                        <input type="text" name="category" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form End -->


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