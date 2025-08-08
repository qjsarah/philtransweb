<!-- Edit Card Modal -->
<div class="modal fade" id="editCardModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form id="editCardForm" method="POST" action="backend/update_card.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCardModalLabel">Edit Card</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="edit-title" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea class="form-control" name="content" id="edit-content" rows="8" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Card</button>
        </div>
      </div>
    </form>
  </div>
</div>

