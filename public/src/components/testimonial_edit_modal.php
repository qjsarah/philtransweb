<!-- Edit Card Modal -->
<div class="modal fade" id="editTestimonial" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="editCardForm" method="POST" action="backend/update_testimonial.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCardModalLabel">Edit Card</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="edit-id-testimonial">
            <textarea name="test_content" class="form-control mb-2" rows="3" placeholder="Testimonial Content" id="edit-content-testimonial" required></textarea>
            <input type="text" name="test_name" class="form-control mb-2" placeholder="Name" id="edit-name" required>
            <input type="text" name="roles" class="form-control mb-2" placeholder="Role" id="edit-roles" required>
            <label for="stars">Rating</label>
            <input type="number" max="5" name="stars" placeholder="Rating" id="edit-rating">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Card</button>
        </div>
      </div>
    </form>
  </div>
</div>

