<!-- Edit Card Modal -->
<div class="modal fade" id="editCardModal" tabindex="-1" style="margin-top: 10%;">
  <div class="modal-dialog modal-dialog-scrollable modal-lg mt-5">
    <form id="editCardForm" method="POST" action="backend/update_card.php">
      <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.56); border-radius: 8px; border: 2px solid black;">
        <div class="modal-header">
          <h5 class="modal-title" id="editCardModalLabel">Card Content</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <hr>
          <input type="hidden" name="id" id="edit-id">
          <div class="mb-3">
            <label class="form-label fw-bold text-secondary">Card Title:</label>
            <input type="text" class="form-control border border-dark" name="title" id="edit-title" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold text-secondary">Card Content:</label>
            <textarea class="form-control border border-dark" name="content" id="edit-content" rows="5" required></textarea>
          </div>
          <hr>
        </div>
        <div class="modal-footer">
          <button type="submit" class="contact_button w-25 px-3 py-2 mt-2 rounded text-dark" style="border-color: black;">Update Card</button>
        </div>
      </div>
    </form>
  </div>
</div>

