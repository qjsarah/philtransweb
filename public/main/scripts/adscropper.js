let cropper;
let currentCmsKey = '';
const cropModal = document.getElementById('cropModal');
const cropperTarget = document.getElementById('cropperTarget');
const cmsKeyField = document.getElementById('cmsKeyField');
const croppedImageField = document.getElementById('croppedImageField');

// Sizes
const cropSizes = {
  ads1: { width: 666, height: 182 },
  ads2: { width: 666, height: 182 },
  person1: { width: 570, height: 617 }, // change this to your desired size
  // Add more as needed
};

// Bind all file inputs
document.querySelectorAll('.cms-image-input').forEach(input => {
  input.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    currentCmsKey = e.target.getAttribute('data-cms-key');
    const cropSize = cropSizes[currentCmsKey];
    if (!cropSize) {
      alert("No crop size defined for " + currentCmsKey);
      return;
    }

    const reader = new FileReader();
    reader.onload = () => {
      cropperTarget.src = reader.result;
      cropModal.style.display = 'block';

      if (cropper) cropper.destroy();

      cropper = new Cropper(cropperTarget, {
        aspectRatio: cropSize.width / cropSize.height,
        viewMode: 1,
        autoCropArea: 1
      });
    };
    reader.readAsDataURL(file);
  });
});


function cropAndUpload() {
  if (!cropper || !currentCmsKey || !cropSizes[currentCmsKey]) return;

  const { width, height } = cropSizes[currentCmsKey];

  const canvas = cropper.getCroppedCanvas({ width, height });

  canvas.toBlob(blob => {
    const formData = new FormData();
    formData.append("cms_key", currentCmsKey);
    formData.append("cms_image", blob, "cropped.png");
    console.log(currentCmsKey);
    fetch("backend/savecms.php", {
      method: "POST",
      body: formData
    })
    .then(response => {
      if (response.ok) {
        window.location.href = "index.php";
      } else {
        alert("Upload failed.");
      }
    })
    .catch(error => {
      console.error("Error uploading image:", error);
      alert("Upload error.");
    });
  }, "image/png");
}