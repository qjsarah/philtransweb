document.querySelectorAll('.restore-button').forEach(button => {
  
  button.addEventListener('click', function (e) {
    e.preventDefault();
    const form = this.closest('form');

    
    const title = 'Are you sure?';
    const text = 'This file will be restored back to the active section!';
    const confirmText = 'Restore';
    const confirmedText = 'Restored';
    const successMsg = 'File has been restored successfully.';

  Swal.fire({
      html: `
        <h2 class="swal-custom-title">${title}</h2>
        <p class="swal-custom-text">${text}</p>
      `,
      showCancelButton: true,
      confirmButtonText: confirmText,
      cancelButtonText: 'Cancel',
      background: '#ffffff',
      color: '#000066',
      buttonsStyling: false,
      imageUrl: '/philtransweb2/public/main/images/archive_section/archivetrycicle.png',
      imageHeight: 200,
      customClass: {
        popup: 'swal-custom-popup',
        title: 'swal-custom-title',
        content: 'swal-custom-text',
        confirmButton: 'swal-button-btn ok-btn',
        cancelButton: 'swal-button-btn cancel-btn',
      },
      didOpen: () => {
        const img = Swal.getImage();
        img.style.marginTop = '-110px';
        const separator = document.createElement('div');
        separator.style.height = '4px';
        separator.style.width = '100%';
        separator.style.backgroundColor = '#000066';
        separator.style.borderRadius = '5px';
        Swal.getPopup().insertBefore(separator, Swal.getPopup().querySelector('.swal2-title'));
      }
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          html: `
            <h2 class="swal-custom-title">${confirmedText} Successfully!</h2>
            <p class="swal-custom-text">${successMsg}</p>
          `,
          showConfirmButton: false,
          timer: 1500,
          background: '#ffffff',
          color: '#000066',
          imageUrl: '/philtransweb2/public/main/images/archive_section/archivetrycicle.png',
          imageHeight: 200,
          customClass: {
            popup: 'swal-custom-popup',
            title: 'swal-custom-title',
            content: 'swal-custom-text',
          },
          didOpen: () => {
            const img = Swal.getImage();
            img.style.marginTop = '-110px';
            const separator = document.createElement('div');
            separator.style.height = '4px';
            separator.style.width = '100%';
            separator.style.backgroundColor = '#000066';
            separator.style.borderRadius = '5px';
            Swal.getPopup().insertBefore(separator, Swal.getPopup().querySelector('.swal2-title'));
          }
        }).then(() => {
          if (form) form.submit();
        });
      }
    });
  });
});
