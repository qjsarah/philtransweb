<section class="py-4">
  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="d-flex flex-column flex-xl-row justify-content-around gap-3">
        <!-- Ads 1 -->
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads5'] ?? 'ads_no_3.png'); ?>" class="ad3 img-fluid current-cms-img" alt="Adkoto image" data-cms-key="ads5" style="max-width: 100%;">
        <!-- Ads 2 -->
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads6'] ?? 'ads_no_4.png'); ?>" class="ad3-2 img-fluid current-cms-img" alt="Adkoto image" data-cms-key="ads6" style="max-width: 100%;">
    </div>
    <!--EDIT BOTAN-->
    <div class="text-center mb-3 ad1">
      <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".edit-ads-5">Edit</button>
    </div>
    <!-- Modal -->
    <div class="modal fade edit-ads-5" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Edit Content</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
          <?php if (isset($_SESSION['user_id'])): ?>
            <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
              <div>
                <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads5'] ?? 'ads_no_3.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads5" style="max-width: 100%; height: auto;">
                <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="ads5" accept="image/*">
              </div>
              <div>
                <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads6'] ?? 'ads_no_4.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads6" style="max-width: 100%; height: auto;">
                <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="ads6" accept="image/*">
              </div>
            </div>
          <?php endif; ?>
          <div id="edit-buttons" class="text-center modal-footer">
            <button type="submit" class="btn btn-success mb-2">Save</button>
            <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
          </div>
      </div>
  </div>
<?php else: ?>
  <div class="ad1 d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
    <div>
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads5'] ?? 'ads_no_3.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads5" style="max-width: 100%; height: auto;">
    </div>
    <div>
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads6'] ?? 'ads_no_4.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads6" style="max-width: 100%; height: auto;">
    </div>
  </div>
<?php endif; ?>
</section>
