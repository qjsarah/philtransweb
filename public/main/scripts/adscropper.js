const imageBase64 = sessionStorage.getItem('tempImage');
const cmsKey = sessionStorage.getItem('cmsKey');

const cropSizes = {
  ads1: { width: 666, height: 182 },
  ads2: { width: 666, height: 182 },
  person1: { width: 570, height: 617 },
  mission_image: {width: 441, height: 411},
  vision_image: {width: 406, height: 411}, 
  ads3: {width: 513, height: 484},
  ads4: {width: 513, height: 484},
  phone_image: {width: 602, height: 683},
  tricycle: {width: 872, height: 649},
  services_image: {width: 1182, height: 445},
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

const cropUploadBtn = document.getElementById("cropUploadBtn");
const cancelBtn = document.getElementById("cancelBtn");

cancelBtn.addEventListener("click", () => {
  sessionStorage.removeItem("tempImage");
  sessionStorage.removeItem("cmsKey");
  window.history.back(); // no upload
});

cropUploadBtn.addEventListener("click", () => {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to save your changes?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, save it!',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#6c757d'
  }).then((result) => {
    if (result.isConfirmed) {
      const { width, height } = cropSize;
      const canvas = cropper.getCroppedCanvas({ width, height });

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
              title: 'Saved!',
              text: 'Your changes have been saved successfully.',
              icon: 'success',
              confirmButtonColor: '#28a745'
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
});