<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <title>Gotong Sampah</title>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

  <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="static/plugin/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">
  <link href="static/plugin/themify-icons/themify-icons.css" rel="stylesheet">
  <link href="static/css/style.css" rel="stylesheet">
  <link href="static/css/color/default.css" rel="stylesheet" id="color_theme">
  <script src="static/js/jquery-3.2.1.min.js"></script>
  <script src="static/plugin/bootstrap/js/bootstrap.js"></script>
  <script src="static/js/custom.js"></script>

  <link href="../static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../static/plugin/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">
  <link href="../static/plugin/themify-icons/themify-icons.css" rel="stylesheet">
  <link href="../static/css/style.css" rel="stylesheet">
  <link href="../static/css/color/default.css" rel="stylesheet" id="color_theme">

</head>
<body data-spy="scroll" data-target="#navbar" data-offset="98">
  <header>
    <nav class="navbar header-nav navbar-expand-lg">
      <div class="container container-large">
        <a class="navbar-brand" href="#">
          <img class="light-logo" src="static/img/logo-light.svg" title="" alt="">
          <img class="dark-logo" src="static/img/logo.svg" title="" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbar">
          <ul class="navbar-nav ml-auto align-items-center">
          	<li><a class="nav-link" href="#">Home</a></li>
            <li><a class="nav-link" href="#about">About</a></li>
            <li><a class="nav-link" href="#enviheroes">Environtment Heroes</a></li>
            <li><a class="nav-link" href="#howitworks">How It Works</a></li>
            <li><a class="nav-link" href="#footer">Kontak Kami</a></li>  
            <?php
              if(isset($this->session->user)){                
                ?>
                <li><a class="nav-link-btn btn btn-theme-2nd m-25px-l md-m-0px-l" href="dashboard/">Explore Donasi</a></li>
                <?php
              }else{
                ?>
                <li><a class="nav-link-btn btn btn-theme-2nd m-25px-l md-m-0px-l" href="auth/login">LOG IN</a></li>                
                <?php
              }
             ?>     
          </ul>
        </div>
      </div>
    </nav> 
  </header>