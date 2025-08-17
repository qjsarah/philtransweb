<!-- Edit Card Modal -->
<div class="modal fade" id="editTestimonial" tabindex="-1">
  <div class="modal-dialog  modal-lg" style="margin-top:9%;">
    <form id="editCardForm" method="POST" action="backend/update_testimonial.php">
      <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.39); border-radius: 8px; border: 2px solid black;">
        <div class="modal-header">
          <h5 class="modal-title" id="editCardModalLabel">Edit Card</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="edit-id-testimonial">

            <label class="form-label fw-bold text-secondary mt-2">Testimonial Content:</label>
            <textarea name="test_content" class="form-control mb-2" rows="3" 
              placeholder="Testimonial Content" id="edit-content-testimonial" required></textarea>

              <label class="form-label fw-bold text-secondary mt-2">Testimonial Name:</label>
            <input type="text" name="test_name" class="form-control mb-2" 
              placeholder="Name" id="edit-name" required>

            <!-- Dropdown for Role -->
            <label class="form-label fw-bold text-secondary mt-2">Testimonial Role:</label>
            <select name="roles" class="form-control mb-2" id="edit-roles" required>
                <option value="">-- Select Role --</option>
                <option value="Driver">Driver</option>
                <option value="User">User</option>
            </select>

            <label class="form-label fw-bold text-secondary mt-2">Testimonial Rating:</label>
            <br>
            <input type="number" max="5" name="stars" placeholder="Rating" id="edit-rating">
        </div>
        <div class="modal-footer">
          <button type="submit" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto mt-3" style="border-color: black">Update Card</button>
        </div>
      </div>
    </form>
  </div>
</div>
