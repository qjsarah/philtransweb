
<div id="testimonial" class="">
</div>

<script src="scripts/data.js"></script>
<script>
    const testimonialDiv = document.getElementById('testimonial');
    testimonialDiv.innerHTML = `
    <div class="vh-100 mt-5">
        <div class="text-danger text-center my-4">
            <h5>What our Client Says</h5>
            <h4 class="fw-bold">TESTIMONIALS</h4>
        </div>
        <div class="owl-carousel owl-theme py-5 align-items-center justify-content-center mt-5 container">
            ${testimonials.map(test => `
            <div class="item text-center p-4 d-flex flex-column mt-5">
                <div class="img-area bg-light">
                    <p class="fw-bolder display-1 text-danger my-auto">"</p>
                </div>
                <p class="mb-3">"${test.text}"</p>
                <div class="text-warning">
                ${'★'.repeat(test.stars)}${'☆'.repeat(5 - test.stars)}
                </div><br>
                <div>
                    <strong>${test.name}</strong><br>
                    <small class="text-muted">${test.role}</small><br>
                </div>
            </div>
            `).join('')}
        </div>
    </div>
        `;
    $('.owl-carousel').owlCarousel({
        rtl: false,
        loop: true,
        margin: 50,
        center: true,
        smartSpeed: 1000,
        autoplay: true,
        autoplayTimeout: 1500,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            960: {
                items: 3
            }
        }
    });
</script>
