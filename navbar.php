<div class="container">
    <nav class="navbar navbar-expand-lg justify-content-center">
      <ul class="navbar-nav d-flex flex-row jsutify-content-center align-items-center" id="navBar">
        <div class="d-flex flex-row nav-left gap-5 layer p-2 px-3 bg-light justify-content-start mt-3">
          <li class="nav-item"><a class="nav-link  text-secondary" href="#">About</a></li>
          <li class="nav-item"><a class="nav-link  text-secondary" href="#">Services</a></li>
        </div>

        <li class="nav-item px-3 w-100 d-flex justify-content-center align-items-center">
            <a class="navbar-brand" href="#" id="logoWrapper">
                <img src="imgs/logo.png" class="logo mx-auto d-block" alt="logo">
            </a>
        </li>



        <div class="d-flex flex-row nav-right gap-5 layer p-2 px-3 bg-light justify-content-end mt-3">
          <li class="nav-item"><a class="nav-link  text-secondary" href="#">Testimonial</a></li>
          <li class="nav-item"><a class="nav-link  text-secondary" href="#">Contact</a></li>
        </div>
      </ul>
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