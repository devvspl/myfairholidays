<?= $this->include('layouts/dashboard_header') ?>
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="page-title-box">
            <h4 class="page-title"><?= $title ?></h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active">Destinations</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <!-- Statistics Cards -->
   <div class="row mb-1">
      <div class="col-xl-3 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded">
                           <i data-lucide="map-pin" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Total Destinations</p>
                     <h4 class="mb-0"><?= $stats['total'] ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-success-subtle text-success rounded">
                           <i data-lucide="check-circle" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Active</p>
                     <h4 class="mb-0"><?= $stats['active'] ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-info-subtle text-info rounded">
                           <i data-lucide="star" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Popular</p>
                     <h4 class="mb-0"><?= $stats['popular'] ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-warning-subtle text-warning rounded">
                           <i data-lucide="globe" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Countries</p>
                     <h4 class="mb-0"><?= $stats['countries'] ?></h4>
                  </div>
               </div>
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
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-header">
               <div class="d-flex justify-content-between align-items-center">
                  <h4 class="card-title mb-0">Destinations List</h4>
                  <div class="btn-group">
                     <a href="<?= base_url('/admin/destinations/trash') ?>" class="btn btn-outline-danger btn-sm">
                     <i data-lucide="trash-2" class="me-1"></i> View Trash
                     </a>
                     <a href="<?= base_url('/admin/destination-types') ?>" class="btn btn-outline-secondary btn-sm">
                     <i data-lucide="tag" class="me-1"></i> Manage Types
                     </a>
                     <a href="<?= base_url('/admin/destinations/create') ?>" class="btn btn-primary btn-sm">
                     <i data-lucide="plus" class="me-1"></i> Add New Destination
                     </a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <?php if (!empty($destinations)): ?>
               <form id="bulkActionForm" method="POST" action="<?= base_url('/admin/destinations/bulk-action') ?>">
                  <?= csrf_field() ?>
                  <div class="row mb-3">
                     <div class="col-md-7">
                        <div class="btn-group">
                           <select name="bulk_action" class="form-select form-select-sm" style="width: auto;">
                              <option value="">Bulk Actions</option>
                              <option value="activate">Activate</option>
                              <option value="deactivate">Deactivate</option>
                              <option value="popular">Mark as Popular</option>
                              <option value="unpopular">Remove Popular</option>
                              <option value="delete">Move to Trash</option>
                           </select>
                           <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
                        </div>
                     </div>
                     <div class="col-md-5">
                        <div class="btn-group">
                            <select class="form-select form-select-sm" id="typeFilter" onchange="filterByType()">
                               <?php foreach ($destinationTypes as $value => $label): ?>
                                    <option value="<?= esc($value) ?>"
                                        <?= ((string) $selectedType === (string) $value) ? 'selected' : '' ?>>
                                        <?= esc($label) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                           <div class="d-flex justify-content-end">
                              <input type="text" class="form-control form-control-sm" placeholder="Search destinations..." style="width: 250px;" id="searchInput">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table table-striped table-hover">
                        <thead>
                           <tr>
                              <th width="30">
                                 <input type="checkbox" class="form-check-input" id="selectAll">
                              </th>
                              <th>Name</th>
                              <th>Type</th>
                              <th>Category</th>
                              <th>Status</th>
                              <th>Popular</th>
                              <th>Created</th>
                              <th width="200">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($destinations as $destination): ?>
                           <tr>
                              <td>
                                 <input type="checkbox" class="form-check-input destination-checkbox" 
                                    name="destination_ids[]" value="<?= $destination['id'] ?>">
                              </td>
                              <td>
                                 <div class="d-flex align-items-center">
                                    <?php if ($destination['image']): ?>
                                    <img src="<?= base_url($destination['image']) ?>" 
                                       alt="<?= esc($destination['name']) ?>" 
                                       class="me-2 rounded" width="32" height="32">
                                    <?php endif; ?>
                                    <div>
                                       <strong class="destination-name"><?= esc($destination['name']) ?></strong>
                                       <?php if (!empty($destination['description'])): ?>
                                       <br><small class="text-muted"><?= esc(substr($destination['description'], 0, 60)) ?>...</small>
                                       <?php endif; ?>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <span class="destination-type"><?= $destination['destination_type'] ?></span>
                              </td>
                              <td>
                                 <span class="badge bg-<?= match ($destination['type'] ?? 'destination') {
            'country' => 'primary',
            'state' => 'info',
            'city' => 'success',
            default => 'secondary'
        } ?>">
                                 <?= ucfirst($destination['type'] ?? 'destination') ?>
                                 </span>
                              </td>
                              <td>
                                 <span class="badge bg-<?= ($destination['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?> status-badge" 
                                    data-destination-id="<?= $destination['id'] ?>" 
                                    data-current-status="<?= $destination['status'] ?? 'active' ?>" 
                                    style="cursor: pointer;" title="Click to toggle status">
                                 <?= ucfirst($destination['status'] ?? 'active') ?>
                                 </span>
                              </td>
                              <td>
                                 <span class="badge bg-<?= !empty($destination['is_popular']) ? 'warning' : 'light text-dark' ?> popular-badge" 
                                    data-destination-id="<?= $destination['id'] ?>" 
                                    data-is-popular="<?= $destination['is_popular'] ?? 0 ?>" 
                                    style="cursor: pointer;" title="Click to toggle popular">
                                 <?= !empty($destination['is_popular']) ? 'Popular' : 'Regular' ?>
                                 </span>
                              </td>
                              <td>
                                 <small class="text-muted">
                                 <?= date('M j, Y', strtotime($destination['created_at'] ?? 'now')) ?>
                                 </small>
                              </td>
                              <td>
                                 <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?= base_url('/admin/destinations/edit/' . $destination['id']) ?>" 
                                       class="btn btn-outline-primary" title="Edit">
                                    <i data-lucide="edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger delete-btn" 
                                       data-destination-id="<?= $destination['id'] ?>" 
                                       data-destination-name="<?= esc($destination['name']) ?>" title="Delete">
                                    <i data-lucide="trash-2"></i>
                                    </button>
                                 </div>
                              </td>
                           </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
               </form>
               <!-- Pagination -->
               <?php if ($pager): ?>
               <div class="d-flex justify-content-center mt-3">
                  <?= $pager->links() ?>
               </div>
               <?php endif; ?>
               <?php else: ?>
               <div class="text-center py-5">
                  <i data-lucide="map-pin" class="text-muted" style="width: 48px; height: 48px;"></i>
                  <h5 class="mt-3 text-muted">No destinations found</h5>
                  <p class="text-muted">Create your first destination to get started.</p>
                  <a href="<?= base_url('/admin/destinations/create') ?>" class="btn btn-primary">
                  <i data-lucide="plus" class="me-1"></i> Create Destination
                  </a>
               </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Confirm Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body">
            <p>Are you sure you want to delete "<span id="destinationName"></span>"?</p>
            <p class="text-muted small">This action cannot be undone.</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
         </div>
      </div>
   </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       let deleteDestinationId = null;
   
       // Select all functionality
       const selectAllCheckbox = document.getElementById('selectAll');
       const destinationCheckboxes = document.querySelectorAll('.destination-checkbox');
       
       selectAllCheckbox?.addEventListener('change', function() {
           destinationCheckboxes.forEach(checkbox => {
               checkbox.checked = this.checked;
           });
       });
   
       // Search functionality
       const searchInput = document.getElementById('searchInput');
       searchInput?.addEventListener('input', function () {
               const searchTerm = this.value.trim().toLowerCase();
               const rows = document.querySelectorAll('tbody tr');
   
               rows.forEach(row => {
                   const nameEl = row.querySelector('.destination-name');
                   const typeEl = row.querySelector('.destination-type');
   
                   if (!nameEl) return;
   
                   const destinationName = nameEl.textContent.toLowerCase();
                   const destinationType = typeEl ? typeEl.textContent.toLowerCase() : '';
   
                   const matchesSearch = destinationName.includes(searchTerm) || destinationType.includes(searchTerm);
                   row.style.display = matchesSearch ? '' : 'none';
               });
           });
   
   
       // Delete functionality
       document.querySelectorAll('.delete-btn').forEach(btn => {
           btn.addEventListener('click', function() {
               deleteDestinationId = this.dataset.destinationId;
               document.getElementById('destinationName').textContent = this.dataset.destinationName;
               new bootstrap.Modal(document.getElementById('deleteModal')).show();
           });
       });
   
       document.getElementById('confirmDelete')?.addEventListener('click', function() {
           if (deleteDestinationId) {
               window.location.href = `/admin/destinations/delete/${deleteDestinationId}`;
           }
       });
   
       // Bulk action form validation
       document.getElementById('bulkActionForm')?.addEventListener('submit', function(e) {
           const selectedDestinations = document.querySelectorAll('.destination-checkbox:checked');
           const bulkAction = document.querySelector('select[name="bulk_action"]').value;
           
           if (selectedDestinations.length === 0) {
               e.preventDefault();
               alert('Please select at least one destination');
               return;
           }
           
           if (!bulkAction) {
               e.preventDefault();
               alert('Please select an action');
               return;
           }
           
           if (!confirm(`Apply "${bulkAction}" to ${selectedDestinations.length} selected destination(s)?`)) {
               e.preventDefault();
           }
       });
   });
   
   // Type filter function
   function filterByType() {
       const typeFilter = document.getElementById('typeFilter').value;
       const currentUrl = new URL(window.location);
       
       if (typeFilter === 'all') {
           currentUrl.searchParams.delete('type');
       } else {
           currentUrl.searchParams.set('type', typeFilter);
       }
       
       window.location.href = currentUrl.toString();
   }
</script>
<?= $this->include('layouts/dashboard_footer') ?>