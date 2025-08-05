function toggleEditAll() {
  const downloadDisplay = document.getElementById('download1-display');
  const downloadForm = document.getElementById('download1-form');
  const paragraphDisplay = document.getElementById('paragraph1-display');
  const paragraphForm = document.getElementById('paragraph1-form');
  const editButtons = document.getElementById('edit-buttons');

  const isEditing = downloadForm.style.display === 'block';

  downloadDisplay.style.display = isEditing ? 'block' : 'none';
  downloadForm.style.display = isEditing ? 'none' : 'block';

  paragraphDisplay.style.display = isEditing ? 'block' : 'none';
  paragraphForm.style.display = isEditing ? 'none' : 'block';

  editButtons.style.display = isEditing ? 'none' : 'block';
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


