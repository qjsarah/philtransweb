const imageBase64 = sessionStorage.getItem('tempImage');
const cmsKey = sessionStorage.getItem('cmsKey');
console.log(cmsKey ?? 'no cmskey');

const cropSizes = {
  ads1: { width: 666, height: 182 },
  ads2: { width: 666, height: 182 },
  person1: { width: 570, height: 617 },
  mission_image: { width: 441, height: 411 },
  vision_image: { width: 406, height: 411 },
  ads3: { width: 513, height: 484 },
  ads4: { width: 513, height: 484 },
  phone_image: { width: 602, height: 683 },
  tricycle: { width: 872, height: 649 },
  services_image: { width: 1182, height: 445 },
  ads5: { width: 666, height: 182 },
  ads6: { width: 666, height: 182 },
  location_img: { width: 46, height: 63 },
  contact_img: { width: 61, height: 45 },
  web_img: { width: 75, height: 80 }
};

if (!imageBase64 || !cmsKey || !cropSizes[cmsKey]) {
  alert("Missing image or CMS key.");
  window.location.href = "../index.php";
}

const cropSize = cropSizes[cmsKey];
const cropperTarget = document.getElementById('cropperTarget');
let cropper;

cropperTarget.src = imageBase64;

cropperTarget.onload = () => {
  cropper = new Cropper(cropperTarget, {
    aspectRatio: cropSize.width / cropSize.height,
    viewMode: 1,
    autoCropArea: 1
  });
};

function cropAndUpload() {
  const { width, height } = cropSize;
  const canvas = cropper.getCroppedCanvas({ width, height });

  Swal.fire({
    html: `
      <h2 class="swal-custom-title">Are you sure?</h2>
      <p class="swal-custom-text">Do you want to save your changes?</p>
    `,
    icon: null,
    showCancelButton: true,
    confirmButtonText: 'Save',
    cancelButtonText: 'Cancel',
    background: '#ffffff',
    color: '#BF0D3D',
    buttonsStyling: false,
    imageUrl: '../../../public/main/images/adscropper_section/adscropperimage.png',
    imageHeight: 200,
    imageAlt: 'Top Image',
    customClass: {
      popup: 'swal-custom-popup',
      confirmButton: 'swal-button-btn ok-btn',
      cancelButton: 'swal-button-btn cancel-btn'
    },
    didOpen: () => {
      const img = Swal.getImage();
      img.style.marginTop = '-110px';
      const separator = document.createElement('div');
      separator.style.height = '4px';
      separator.style.width = '100%';
      separator.style.backgroundColor = '#BF0D3D';
      separator.style.borderRadius = '5px';
      const popup = Swal.getPopup();
      popup.insertBefore(separator, popup.querySelector('.swal2-title'));
    }
  }).then((result) => {
    if (result.isConfirmed) {
      canvas.toBlob(blob => {
        const formData = new FormData();
        formData.append("cms_key", cmsKey);
        formData.append("cms_image", blob, "cropped.png");

        fetch("../backend/savecms.php", {
          method: "POST",
          body: formData
        })
        .then(res => {
          if (res.ok) {
            Swal.fire({
              html: `
                <h2 class="swal-custom-title">Saved Successfully!</h2>
                <p class="swal-custom-text">Your changes have been saved successfully.</p>
              `,
              icon: null,
              showConfirmButton: false,
              timer: 1500,
              background: '#ffffff',
              color: '#BF0D3D',
              imageUrl: '../../../public/main/images/adscropper_section/adscropperimage.png',
              imageHeight: 200,
              imageAlt: 'Top Image',
              customClass: {
                popup: 'swal-custom-popup'
              },
              didOpen: () => {
                const img = Swal.getImage();
                img.style.marginTop = '-110px';
                const separator = document.createElement('div');
                separator.style.height = '4px';
                separator.style.width = '100%';
                separator.style.backgroundColor = '#BF0D3D';
                separator.style.borderRadius = '5px';
                const popup = Swal.getPopup();
                popup.insertBefore(separator, popup.querySelector('.swal2-title'));
              }
            }).then(() => {
              sessionStorage.removeItem("tempImage");
              sessionStorage.removeItem("cmsKey");
              window.history.back(); 
            });
          } else {
            alert("Upload failed.");
          }
        })
        .catch(err => {
          console.error("Upload error", err);
          alert("Something went wrong.");
        });
      }, "image/png");
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const cancelBtn = document.getElementById("cancelBtn");
  const cropUploadBtn = document.getElementById("cropUploadBtn");


  cancelBtn.addEventListener("click", () => {
    window.history.back();
  });

  
  cropUploadBtn.addEventListener("click", () => {
    cropAndUpload();
  });
});
