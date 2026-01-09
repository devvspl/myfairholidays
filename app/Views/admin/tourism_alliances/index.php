<?= $this->include('layouts/dashboard_header') ?>
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="page-title-box">
            <h4 class="page-title"><?= $title ?></h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active">Tourism Alliances</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <?php if (session()->getFlashdata('success')): ?>
   <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
   </div>
   <?php endif; ?>
   <?php if (session()->getFlashdata('error')): ?>
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
   </div>
   <?php endif; ?>
   <!-- Statistics Cards -->
   <div class="row mb-1">
      <div class="col-md-3">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between">
                  <div>
                     <h5 class="card-title text-muted mb-0">Total Alliances</h5>
                     <h3 class="mb-0"><?= $stats['total'] ?></h3>
                  </div>
                  <div class="align-self-center">
                     <i data-lucide="users" class="icon-lg text-primary"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between">
                  <div>
                     <h5 class="card-title text-muted mb-0">Active</h5>
                     <h3 class="mb-0 text-success"><?= $stats['active'] ?></h3>
                  </div>
                  <div class="align-self-center">
                     <i data-lucide="check-circle" class="icon-lg text-success"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between">
                  <div>
                     <h5 class="card-title text-muted mb-0">Tourism Boards</h5>
                     <h3 class="mb-0 text-info"><?= $stats['tourism_boards'] ?></h3>
                  </div>
                  <div class="align-self-center">
                     <i data-lucide="map" class="icon-lg text-info"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between">
                  <div>
                     <h5 class="card-title text-muted mb-0">Airlines</h5>
                     <h3 class="mb-0 text-warning"><?= $stats['airlines'] ?></h3>
                  </div>
                  <div class="align-self-center">
                     <i data-lucide="plane" class="icon-lg text-warning"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-header">
               <div class="d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="card-title mb-0">Tourism Alliances</h4>
                     <?php if (!empty($searchTerm)): ?>
                        <small class="text-muted">Search results for "<?= esc($searchTerm) ?>"</small>
                     <?php endif; ?>
                  </div>
                  <div class="btn-group" role="group" aria-label="Alliance actions">
                     <a href="<?= base_url('/admin/tourism-alliances/trash') ?>" class="btn btn-sm btn-outline-danger">
                     <i data-lucide="trash-2" class="me-1"></i>
                     Trash (<?= $stats['trashed'] ?>)
                     </a>
                     <a href="<?= base_url('/admin/tourism-alliances/create') ?>" class="btn btn-sm btn-primary">
                     <i data-lucide="plus" class="me-1"></i>
                     Add New Alliance
                     </a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <?php if (!empty($alliances)): ?>
               <!-- Search and Bulk Actions Form -->
               <form method="post" action="<?= base_url('/admin/tourism-alliances/bulk-action') ?>" id="bulkActionForm">
                  <?= csrf_field() ?>
                  <div class="row mb-3">
                     <div class="col-md-6">
                        <div class="btn-group">
                           <select class="form-select form-select-sm" style="width: auto;" name="bulk_action" id="bulkAction">
                              <option value="">Bulk Actions</option>
                              <option value="activate">Activate</option>
                              <option value="deactivate">Deactivate</option>
                              <option value="delete">Move to Trash</option>
                           </select>
                           <button type="submit" class="btn btn-sm btn-secondary" id="bulkActionBtn" disabled>Apply</button>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                           <div class="input-group" style="width: 300px;">
                              <input type="text" class="form-control form-control-sm" placeholder="Search alliances..." id="searchInput" value="<?= esc($searchTerm ?? '') ?>">
                              <button class="btn btn-outline-secondary btn-sm" type="button" id="searchBtn">
                                 <i data-lucide="search"></i>
                              </button>
                              <?php if (!empty($searchTerm)): ?>
                              <a href="<?= base_url('/admin/tourism-alliances') ?>" class="btn btn-outline-danger btn-sm" title="Clear search">
                                 <i data-lucide="x"></i>
                              </a>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>
               <div class="table-responsive">
                  <table class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th width="50">
                              <input type="checkbox" id="selectAll" class="form-check-input">
                           </th>
                           <th width="80">Logo</th>
                           <th>Name</th>
                           <th>Type</th>
                           <th>Status</th>
                           <th>Sort Order</th>
                           <th>Created</th>
                           <th width="150">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($alliances as $alliance): ?>
                        <tr>
                           <td>
                              <input type="checkbox" name="alliance_ids[]" value="<?= $alliance['id'] ?>" class="form-check-input alliance-checkbox">
                           </td>
                           <td>
                              <?php if (!empty($alliance['logo'])): ?>
                              <img src="<?= base_url($alliance['logo']) ?>" alt="<?= esc($alliance['name']) ?>" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                              <?php else: ?>
                              <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                 <i data-lucide="image" class="text-muted"></i>
                              </div>
                              <?php endif; ?>
                           </td>
                           <td>
                              <div>
                                 <strong><?= esc($alliance['name']) ?></strong>
                                 <?php if (!empty($alliance['website_url'])): ?>
                                 <br><small><a href="<?= esc($alliance['website_url']) ?>" target="_blank" class="text-primary"><?= esc($alliance['website_url']) ?></a></small>
                                 <?php endif; ?>
                              </div>
                           </td>
                           <td>
                              <span class="badge bg-info"><?= ucwords(str_replace('_', ' ', $alliance['type'])) ?></span>
                           </td>
                           <td>
                              <span class="badge bg-<?= $alliance['status'] === 'active' ? 'success' : 'secondary' ?>">
                              <?= ucfirst($alliance['status']) ?>
                              </span>
                           </td>
                           <td><?= $alliance['sort_order'] ?></td>
                           <td><?= date('M d, Y', strtotime($alliance['created_at'])) ?></td>
                           <td>
                              <div class="btn-group" role="group">
                                 <a href="<?= base_url('/admin/tourism-alliances/show/' . $alliance['id']) ?>" class="btn btn-sm btn-outline-info" title="View">
                                 <i data-lucide="eye"></i>
                                 </a>
                                 <a href="<?= base_url('/admin/tourism-alliances/edit/' . $alliance['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                 <i data-lucide="edit"></i>
                                 </a>
                                 <a href="<?= base_url('/admin/tourism-alliances/delete/' . $alliance['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete" 
                                    onclick="return confirm('Are you sure you want to delete this alliance?')">
                                 <i data-lucide="trash-2"></i>
                                 </a>
                              </div>
                           </td>
                        </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
               </form>
               <div class="row mt-3">
                  <div class="col-md-12">
                     <?= $pager->links() ?>
                  </div>
               </div>
               <?php else: ?>
               <div class="text-center py-5">
                  <i data-lucide="users" class="icon-xxl text-muted mb-3"></i>
                  <h5>No Tourism Alliances Found</h5>
                  <p class="text-muted">Get started by creating your first tourism alliance.</p>
                  <a href="<?= base_url('/admin/tourism-alliances/create') ?>" class="btn btn-primary">
                  <i data-lucide="plus" class="me-1"></i> Add New Alliance
                  </a>
               </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       // Select all functionality
       const selectAll = document.getElementById('selectAll');
       const checkboxes = document.querySelectorAll('.alliance-checkbox');
       const bulkActionBtn = document.getElementById('bulkActionBtn');
       const bulkActionForm = document.getElementById('bulkActionForm');
       const searchInput = document.getElementById('searchInput');
       const searchBtn = document.getElementById('searchBtn');

       // Select all checkbox functionality
       selectAll?.addEventListener('change', function() {
           checkboxes.forEach(checkbox => {
               checkbox.checked = this.checked;
           });
           updateBulkActionButton();
       });

       // Individual checkbox functionality
       checkboxes.forEach(checkbox => {
           checkbox.addEventListener('change', function() {
               updateBulkActionButton();
               updateSelectAllState();
           });
       });

       function updateBulkActionButton() {
           const checkedBoxes = document.querySelectorAll('.alliance-checkbox:checked');
           bulkActionBtn.disabled = checkedBoxes.length === 0;
       }

       function updateSelectAllState() {
           const totalCheckboxes = checkboxes.length;
           const checkedCheckboxes = document.querySelectorAll('.alliance-checkbox:checked').length;
           
           if (checkedCheckboxes === 0) {
               selectAll.indeterminate = false;
               selectAll.checked = false;
           } else if (checkedCheckboxes === totalCheckboxes) {
               selectAll.indeterminate = false;
               selectAll.checked = true;
           } else {
               selectAll.indeterminate = true;
               selectAll.checked = false;
           }
       }

       // Search functionality
       function performSearch() {
           const searchTerm = searchInput.value.trim();
           const currentUrl = new URL(window.location.href);
           
           if (searchTerm) {
               currentUrl.searchParams.set('search', searchTerm);
           } else {
               currentUrl.searchParams.delete('search');
           }
           
           window.location.href = currentUrl.toString();
       }

       searchBtn?.addEventListener('click', performSearch);
       
       searchInput?.addEventListener('keypress', function(e) {
           if (e.key === 'Enter') {
               e.preventDefault();
               performSearch();
           }
       });

       // Bulk action form submission
       bulkActionForm?.addEventListener('submit', function(e) {
           const checkedBoxes = document.querySelectorAll('.alliance-checkbox:checked');
           const bulkAction = document.querySelector('select[name="bulk_action"]').value;
           
           if (checkedBoxes.length === 0) {
               e.preventDefault();
               alert('Please select at least one alliance');
               return;
           }

           if (!bulkAction) {
               e.preventDefault();
               alert('Please select an action');
               return;
           }

           // Confirmation for delete action
           if (bulkAction === 'delete') {
               if (!confirm(`Are you sure you want to move ${checkedBoxes.length} alliance(s) to trash?`)) {
                   e.preventDefault();
                   return;
               }
           }

           // Confirmation for other actions
           const actionText = bulkAction === 'activate' ? 'activate' : 'deactivate';
           if (bulkAction !== 'delete') {
               if (!confirm(`Are you sure you want to ${actionText} ${checkedBoxes.length} alliance(s)?`)) {
                   e.preventDefault();
                   return;
               }
           }
       });

       // Status toggle functionality (if toggle buttons exist)
       document.querySelectorAll('.toggle-status').forEach(button => {
           button.addEventListener('click', function() {
               const id = this.dataset.id;
               const currentStatus = this.dataset.status;
               
               fetch(`<?= base_url('/admin/tourism-alliances/toggle-status/') ?>${id}`, {
                   method: 'POST',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-Requested-With': 'XMLHttpRequest',
                       'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                   }
               })
               .then(response => response.json())
               .then(data => {
                   if (data.success) {
                       location.reload(); // Reload to show updated status
                   } else {
                       alert('Failed to update status: ' + (data.message || 'Unknown error'));
                   }
               })
               .catch(error => {
                   console.error('Error:', error);
                   alert('An error occurred while updating the status');
               });
           });
       });

       // Initialize bulk action button state
       updateBulkActionButton();
       updateSelectAllState();
   });
</script>
<?= $this->include('layouts/dashboard_footer') ?>