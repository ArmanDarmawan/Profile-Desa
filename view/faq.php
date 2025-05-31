<?php 
include 'template/header.php';
include '../db/connection.php';
 ?>
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area white-bg">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                            <div class="logo-img">
                                <a href="../index.php">
                                    <img src="../img/logo.png" alt="Logo Desa" class="img-fluid">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-9 col-sm-8 col-6">
                            <div class="main-menu d-none d-lg-block text-right">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="../index.php">Home</a></li>
                                        <li><a href="galeri.php">Galeri</a></li>
                                        <li><a href="sejarah.php">Sejarah</a></li>
                                        <li><a href="peta.php">Peta Desa</a></li>
                                        <li><a href="loker.php">Loker</a></li>
                                        <li><a href="../admin/index.php">Dashboard</a></li>
                                        <li><a href="hubungi.php">Hubungi</a></li>
                                        <li><a class="active" href="faq.php">FAQ</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-12 d-lg-none">
                                <div class="mobile_menu"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="breadcrumb breadcrumb_bg banner-bg-1 overlay2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="breadcrumb_iner text-center">
                        <div class="breadcrumb_iner_item">
                            <h2>FAQ (Pertanyaan Umum)</h2>
                            <p>Temukan jawaban atas pertanyaan yang sering diajukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="faq-area section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div id="accordionFaq">
                        <?php
                        $sql_faq = "SELECT * FROM faq ORDER BY urutan ASC, id ASC";
                        $query_faq = mysqli_query($connection, $sql_faq);
                        $count = 0;
                        if (mysqli_num_rows($query_faq) > 0) {
                            while ($row = mysqli_fetch_assoc($query_faq)) {
                                $count++;
                                $collapseId = "collapse" . $count;
                                $headingId = "heading" . $count;
                                // Determine if this item should be open by default (only the first one)
                                $isOpen = ($count == 1); 
                        ?>
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header" id="<?php echo $headingId; ?>">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-block text-left <?php echo !$isOpen ? 'collapsed' : ''; ?>" type="button" data-toggle="collapse"
                                        data-target="#<?php echo $collapseId; ?>" aria-expanded="<?php echo $isOpen ? 'true' : 'false'; ?>" aria-controls="<?php echo $collapseId; ?>">
                                        <?php echo htmlspecialchars($row['pertanyaan']); ?>
                                        <i class="fa fa-chevron-down float-right"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="<?php echo $collapseId; ?>" class="collapse <?php echo $isOpen ? 'show' : ''; ?>" aria-labelledby="<?php echo $headingId; ?>"
                                data-parent="#accordionFaq">
                                <div class="card-body">
                                    <?php echo nl2br(htmlspecialchars($row['jawaban'])); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo "<div class='col-12'><p class='alert alert-info text-center'>Belum ada FAQ yang tersedia saat ini.</p></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
// The footer was manually included in the original file, 
// so we ensure it's called correctly via template/footer.php
include 'template/footer.php';
?>
