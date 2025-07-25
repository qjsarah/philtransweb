<div class="container position-relative mb-3 desktop">
    <nav class="navbar navbar-expand-lg justify-content-center fw-bold">
      <ul class="navbar-nav d-flex flex-row jsutify-content-center align-items-center" id="navBar">
        <div class="d-flex flex-row nav-left gap-5 layer p-2 px-3 bg-light justify-content-start mt-3 me-5">
          <li class="nav-item"><a class="nav-link  text-secondary" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link  text-secondary" href="#services">Services</a></li>
        </div>

        <li class="nav-item px-3 w-100 d-flex justify-content-center align-items-center">
            <a class="navbar-brand" href="#" id="logoWrapper">
                <img src="imgs/logo.png" class="logo mx-auto d-block" alt="logo">
            </a>
        </li>

        <div class="d-flex flex-row nav-right gap-5 layer p-2 px-3 bg-light justify-content-end mt-3 ms-5">
          <li class="nav-item"><a class="nav-link  text-secondary" href="#testimonial">Testimonial</a></li>
          <li class="nav-item"><a class="nav-link  text-secondary" href="#">Contact</a></li>
        </div>
      </ul>
    </nav>
</div>
<div class="mb-2 mobile">
  <nav class="navbar navbar-expand-lg justify-content-between fw-bold">
    <a class="navbar-brand" href="#">
      <img src="imgs/logo.png" class="logo mx-auto d-block" alt="logo">
    </a>
    <button class="navbar-toggler collapsed custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <div class="bar1 bg-secondary"></div>
        <div class="bar2 bg-secondary"></div>
        <div class="bar3 bg-secondary"></div>
    </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav text-end" id="navBar">
          <li class="nav-item"><a class="nav-link  text-secondary" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link  text-secondary" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link  text-secondary" href="#testimonial">Testimonial</a></li>
          <li class="nav-item"><a class="nav-link  text-secondary" href="#">Contact</a></li>
        </ul>
      </div>
    </nav>
</div>
<script>
    const logo = document.getElementById('logoWrapper');
    const navBar = document.getElementById('navBar');

    logo.addEventListener('mouseenter', () => {
        navBar.classList.add('show-nav');
    });

    navBar.addEventListener('mouseleave', () => {
        navBar.classList.remove('show-nav');
    });
</script>