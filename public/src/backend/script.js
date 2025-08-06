function toggleEditAll(button) {
  const targetSelector = button.getAttribute('data-modal-target');
  const modalElement = document.querySelector(targetSelector);

  if (!modalElement) {
    console.error('Modal not found:', targetSelector);
    return;
  }

  const modalInstance = new bootstrap.Modal(modalElement);
  modalInstance.show();
}

function toggleEditAboutUs() {
  const aboutDisplay = document.getElementById  ('aboutus-view')
  const aboutusForm = document.getElementById('aboutus-form');
  const editButtons = document.getElementById('aboutus-edit-buttons');
  const isEditing = aboutusForm.style.display === 'block';

  aboutDisplay.style.display = isEditing ? 'block' : 'none';
  aboutusForm.style.display = isEditing ? 'none' : 'block';
  editButtons.style.display = isEditing ? 'none' : 'block';
}

function toggleEditMV() {
  const mvView = document.getElementById('mv-view');
  const mvForm = document.getElementById('mv-form');
  const isEditing = mvForm.style.display === 'block';

  mvView.style.display = isEditing ? 'block' : 'none';
  mvForm.style.display = isEditing ? 'none' : 'block';
}


