<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= $title?> </title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <link href="<?php echo base_url() ?>static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>static/plugin/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>static/plugin/themify-icons/themify-icons.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>static/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>static/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>static/css/color/default.css" rel="stylesheet" id="color_theme">
    <script src="<?php echo base_url() ?>static/js/jquery-3.2.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>static/plugin/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <style>
        .modal {
            overflow-y: auto;
        }
    </style>
    <script>
        var baseURL = "<?= base_url() ?>";
        $(document).ready(function() {
            $(window).scroll(function() {
                var y = $(window).scrollTop();
                if (y > 0) {
                    $("#head_navbar").addClass('shadow-lg');
                } else {
                    $("#head_navbar").removeClass('shadow-lg');
                }
            });
        });
    </script>

</head>

<body data-spy="scroll" data-target="#navbar" data-offset="98">
    <header>
        <nav id="head_navbar" class="navbar header-nav navbar-expand-lg bg-white navbar-white sticky-top ">
            <div class="container container-large">
                <a class="navbar-brand" href="#">
                    <img class="light-logo" src="<?php echo base_url() ?>static/img/logo.svg" title="" alt="" onclick="location.href='<?= base_url()?>dashboard/'">
                    <img class="dark-logo" src="<?php echo base_url() ?>static/img/logo.svg" title="" alt="" onclick="location.href='<?= base_url()?>dashboard/'">
                </a>
                <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbar">
                    <ul class="navbar-nav align-items-center">
                        <li><a class="btn btn-theme-yellow" href="<?= base_url()?>dashboard/">Home</a></li>
                        <?php
                        //if for user or mitra
                        if ($type == 'user') {
                            ?>
                            <li><a class="btn btn-theme-yellow btn_Donasi" href="input_donasi.php">DONASI SEKARANG</a></li>
                        <?php
                        } else {
                            //nothing to show
                        }
                        ?>

                        <li class="nav-item dropdown">
                            <div><a href="#" class="ti-user icon-s border-radius yellow-bg" data-toggle="dropdown" role="button"></a>
                                <div class="dropdown-menu dropdown-menu-right scale-up">
                                    <?php
                                    if ($session_data[0]['nama'] === NULL) {
                                        echo '<a href="#" class="dropdown-item"><i class="ti-user"></i> ' . $session_data[0]["username"] . '</a>';
                                    } else {
                                        echo '<a href="#" class="dropdown-item"><i class="ti-user"></i> ' . $session_data[0]["nama"] . '</a>';
                                    }

                                    ?>

                                    <a href="<?php echo base_url() ?>profile/history" class="dropdown-item"><i class="ti-wallet"></i> Riwayat <?php echo ($type == "user") ? "Donasi" : "Bermitra" ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a href="<?php echo base_url() ?>profile/settings" class="dropdown-item">
                                        <i class="ti-settings"></i> Pengaturan Akun
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="<?php echo base_url() ?>auth/logout" class="dropdown-item">
                                        <i class="fa fa-power-off"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>