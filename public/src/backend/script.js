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