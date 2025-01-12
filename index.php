<?php
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pemrograman Berbasi Web</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      .hero {
        margin: 90px;
      }
      .home{
        padding-bottom: 180px;
      }
      .gallery{
        padding: 50px;
      }
      
      .kotak {
        max-width: 500px;
        margin: 0 auto;
        padding: 10px;
      }
    </style>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

     <!--JS JAM-->

    <script type="text/javascript">
      window.setTimeout(tampilwaktu, 1000);
    
      function tampilwaktu() {
        var waktu = new Date();
        var bulan = waktu.getMonth() + 1;
    
        document.getElementById("tanggal").innerHTML = 
          waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
        document.getElementById("jam").innerHTML = 
          waktu.getHours() + ":" + waktu.getMinutes() + ":" + waktu.getSeconds();
    
        setTimeout(tampilwaktu, 1000);
      }
    </script>
    
    <!--NAV BAR-->

    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="img/udinus.jpg" alt="" style="height: 50px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto text-dark mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#article">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#gallery">Gallery</a>
            </li>
              <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          </ul>

          <div class="dropdown ms-4" id="themeDropdown">
            <button class="btn nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi-sun-fill theme-icon-active" 
                  data-theme-icon-active="bi-sun-fill"></i>
  
            </button>
        
            <ul class="dropdown-menu dropdown-menu-end my-2" aria-labelledby="dropdownMenuButton" data-bs-popper="static">
                <li>
                  <button class="dropdown-item d-flex align-item-center" type="button" data-bs-theme-value="light">
                    <i class="bi bi-sun-fill me-2 opacity-50" data-theme-icon="bi-sun-fill"></i>
                    Light
                  </button>
                </li>
                <li>
                  <button class="dropdown-item d-flex align-item-center" type="button" data-bs-theme-value="dark">
                    <i class="bi bi-moon-stars-fill me-2 opacity-50" data-theme-icon="bi-moon-stars-fill"></i>
                    Dark
                  </button>
                </li>
               
            </ul>
        </div>

        </div>
      </div>
    </nav>

    <!--HOME-->
    <div class="hero text-sm-start">
      <div class="home">
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img src="img/IMG_3450.JPG" class="img-fluid" width="300" alt="Udinus" />
          <div>
            <h1 class="fw-bold display-4">Udinus Memeroleh Medali?</h1>
            <h4 class="lead display-6">
              Beberapa Mahasiswa UDINUS Juga Berkontribusi Untuk Indonesia Lho. Berikut Beberapa Mahasiswa UDINUS Peroleh Medali.
            </h4>
            <h6>
                <span id="tanggal"></span>
                <span id="jam"></span>
              </h6>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br>

  <!--Article-->
  <!-- article begin -->
<section id="article" class="text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">article</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
      <?php
      $sql = "SELECT * FROM article ORDER BY tanggal DESC";
      $hasil = $conn->query($sql); 

      while($row = $hasil->fetch_assoc()){
      ?>
        <div class="col">
          <div class="card h-100">
            <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title"><?= $row["judul"]?></h5>
              <p class="card-text">
                <?= $row["isi"]?>
              </p>
            </div>
            <div class="card-footer">
              <small class="text-body-secondary">
                <?= $row["tanggal"]?>
              </small>
            </div>
          </div>
        </div>
        <?php
      }
      ?> 
    </div>
  </div>
</section>
<!-- article end -->
  <!--GALLERY-->
<gallery>
  <h1 class="text-center" id="gallery">Gallery</h1>
  <br>
  <br>
  <div class="kotak">
    <div id="carouselExample" class="carousel slide">
      <div class="carousel-inner">
        <?php
        include 'koneksi.php'; // Sambungkan ke database
        $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
        $hasil = $conn->query($sql);
        $active = true; // Set item pertama sebagai active
        while ($row = $hasil->fetch_assoc()) {
        ?>
        <div class="carousel-item <?= $active ? 'active' : '' ?>">
          <img src="img/<?= $row['gambar'] ?>" class="d-block w-100" alt="Gallery Image">
        </div>
        <?php
          $active = false; // Nonaktifkan active setelah item pertama
        }
        ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</gallery>


  <br>
  <br>

  <footer class="py-3 my-4 shared-padding">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item">
        <a href="#" class="nav-link px-2 text-body-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
          <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z"/>
        </svg></a>
      </li>
      <li class="nav-item">
        <a href="#article" class="nav-link px-2 text-body-secondary"
          ><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-book-half" viewBox="0 0 16 16">
            <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
          </svg></a
        >
      </li>
      <li class="nav-item">
        <a href="#gallery" class="nav-link px-2 text-body-secondary"
          ><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
            <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
          </svg></a
        >
      </li>
    </ul>

    <p class="text-center text-body-secondary">© 2024 Fernandito Ibrahim Maryana</p>
  </footer>


  <script>
      

    (() => {
     'use strict';
   
     const setTheme = (theme) => {
       document.documentElement.setAttribute('data-bs-theme', theme); 
       localStorage.setItem('theme', theme);
     };
   
     const getStoredTheme = () => localStorage.getItem('theme') || 'light'; 
   
     const updateActiveThemeIcon = (theme) => {
       const themeIconActive = document.querySelector('.theme-icon-active');
       const activeButton = document.querySelector(`[data-bs-theme-value="${theme}"]`);
       const newIconClass = activeButton.querySelector('i').dataset.themeIcon;
   
       themeIconActive.classList.remove(themeIconActive.dataset.themeIconActive);
       themeIconActive.classList.add(newIconClass);
       themeIconActive.dataset.themeIconActive = newIconClass;
     };
   
     const showActiveTheme = (theme) => {
       document.querySelectorAll('[data-bs-theme-value]').forEach((btn) => {
         btn.classList.remove('active');
         btn.setAttribute('aria-pressed', 'false');
       });
   
       const activeButton = document.querySelector(`[data-bs-theme-value="${theme}"]`);
       if (activeButton) {
         activeButton.classList.add('active');
         activeButton.setAttribute('aria-pressed', 'true');
       }
   
       updateActiveThemeIcon(theme);
     };
   
     const initialTheme = getStoredTheme();
     setTheme(initialTheme);
     showActiveTheme(initialTheme);
   
     document.querySelectorAll('[data-bs-theme-value]').forEach((btn) => {
       btn.addEventListener('click', () => {
         const selectedTheme = btn.getAttribute('data-bs-theme-value');
         setTheme(selectedTheme);
         showActiveTheme(selectedTheme);
       });
     });
   })();
   
   
       </script>

</body>
</html>