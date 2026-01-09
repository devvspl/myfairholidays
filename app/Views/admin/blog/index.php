<?= $this->include('layouts/dashboard_header') ?>
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="page-title-box">
            <h4 class="page-title"><?= $title ?></h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active">Blog Posts</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <!-- Statistics Cards -->
   <div class="row mb-1">
      <!-- Total Posts -->
      <div class="col-md-3 col-sm-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded">
                           <i data-lucide="file-text" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Total Posts</p>
                     <h4 class="mb-0"><?= $stats['total'] ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Published -->
      <div class="col-md-3 col-sm-6">
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
                     <p class="text-muted mb-1">Published</p>
                     <h4 class="mb-0"><?= $stats['published'] ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Drafts -->
      <div class="col-md-3 col-sm-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-warning-subtle text-warning rounded">
                           <i data-lucide="edit-3" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Drafts</p>
                     <h4 class="mb-0"><?= $stats['draft'] ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Trashed -->
      <div class="col-md-3 col-sm-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-danger-subtle text-danger rounded">
                           <i data-lucide="trash-2" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Trashed</p>
                     <h4 class="mb-0"><?= $stats['trashed'] ?></h4>
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
                  <h4 class="card-title mb-0">Blog Posts</h4>
                  <div class="btn-group">
                     <a href="<?= base_url('/admin/blogs/trash') ?>" class="btn btn-outline-danger btn-sm">
                     <i data-lucide="trash-2" class="me-1"></i> View Trash
                     </a>
                     <a href="<?= base_url('/admin/blogs/create') ?>" class="btn btn-primary btn-sm">
                     <i data-lucide="plus" class="me-1"></i> Add New Post
                     </a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <?php if (!empty($posts)): ?>
               <form id="bulkActionForm" method="POST" action="<?= base_url('/admin/blogs/bulk-action') ?>">
                  <?= csrf_field() ?>
                  <div class="row mb-3">
                     <div class="col-md-6">
                        <div class="btn-group">
                           <select name="bulk_action" class="form-select form-select-sm" style="width: auto;">
                              <option value="">Bulk Actions</option>
                              <option value="publish">Publish</option>
                              <option value="draft">Move to Draft</option>
                              <option value="feature">Mark as Featured</option>
                              <option value="unfeature">Remove Featured</option>
                              <option value="delete">Move to Trash</option>
                           </select>
                           <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                           <input type="text" class="form-control form-control-sm" placeholder="Search posts..." style="width: 250px;" id="searchInput">
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
                              <th>Title</th>
                              <th>Status</th>
                              <th>Featured</th>
                              <th>Author</th>
                              <th>Created</th>
                              <th width="200">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($posts as $post): ?>
                           <tr>
                              <td>
                                 <input type="checkbox" class="form-check-input post-checkbox" 
                                    name="post_ids[]" value="<?= $post['id'] ?>">
                              </td>
                              <td>
                                 <div class="d-flex align-items-center">
                                    <?php if ($post['featured_image']): ?>
                                    <img src="<?= base_url($post['featured_image']) ?>" 
                                       alt="Featured" class="me-2 rounded" width="40" height="60">
                                    <?php endif; ?>
                                    <div>
                                       <strong><?= esc($post['title']) ?></strong>
                                       <?php if (!empty($post['excerpt'])): ?>
                                       <br><small class="text-muted"><?= esc(substr($post['excerpt'], 0, 60)) ?>...</small>
                                       <?php endif; ?>
                                    </div>
                                 </div>
                              </td>
                              <td>
                                 <span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'warning' ?> status-badge" 
                                    data-post-id="<?= $post['id'] ?>" style="cursor: pointer;">
                                 <?= ucfirst($post['status']) ?>
                                 </span>
                              </td>
                              <td>
                                 <span class="badge bg-<?= !empty($post['is_featured']) ? 'info' : 'secondary' ?> featured-badge" 
                                    data-post-id="<?= $post['id'] ?>" style="cursor: pointer;">
                                 <?= !empty($post['is_featured']) ? 'Featured' : 'Regular' ?>
                                 </span>
                              </td>
                              <td><?= esc($post['author_name']) ?></td>
                              <td>
                                 <small class="text-muted">
                                 <?= date('M j, Y', strtotime($post['created_at'])) ?>
                                 </small>
                              </td>
                              <td>
                                 <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?= base_url('/admin/blogs/show/' . $post['id']) ?>" 
                                       class="btn btn-outline-info" title="View">
                                    <i data-lucide="eye"></i>
                                    </a>
                                    <a href="<?= base_url('/admin/blogs/edit/' . $post['id']) ?>" 
                                       class="btn btn-outline-primary" title="Edit">
                                    <i data-lucide="edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger delete-btn" 
                                       data-post-id="<?= $post['id'] ?>" 
                                       data-post-title="<?= esc($post['title']) ?>" title="Delete">
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
                  <i data-lucide="file-text" class="text-muted" style="width: 48px; height: 48px;"></i>
                  <h5 class="mt-3 text-muted">No blog posts found</h5>
                  <p class="text-muted">Create your first blog post to get started.</p>
                  <a href="<?= base_url('/admin/blogs/create') ?>" class="btn btn-primary">
                  <i data-lucide="plus" class="me-1"></i> Create Post
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
            <p>Are you sure you want to move "<span id="postTitle"></span>" to trash?</p>
            <p class="text-muted small">You can restore it later from the trash.</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Move to Trash</button>
         </div>
      </div>
   </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       // Select all functionality
       const selectAllCheckbox = document.getElementById('selectAll');
       const postCheckboxes = document.querySelectorAll('.post-checkbox');
       
       selectAllCheckbox?.addEventListener('change', function() {
           postCheckboxes.forEach(checkbox => {
               checkbox.checked = this.checked;
           });
       });
   
       // Search functionality
       const searchInput = document.getElementById('searchInput');
       searchInput?.addEventListener('keyup', function() {
           const searchTerm = this.value.toLowerCase();
           const tableRows = document.querySelectorAll('tbody tr');
           
           tableRows.forEach(row => {
               const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
               
               if (title.includes(searchTerm)) {
                   row.style.display = '';
               } else {
                   row.style.display = 'none';
               }
           });
       });
   
       // Status toggle
       document.querySelectorAll('.status-badge').forEach(badge => {
           badge.addEventListener('click', function() {
               const postId = this.dataset.postId;
               
               AdminUtils.makeRequest(`/admin/blogs/toggle-status/${postId}`, 'POST')
                   .then(response => {
                       if (response.success) {
                           this.textContent = response.status.charAt(0).toUpperCase() + response.status.slice(1);
                           this.className = `badge bg-${response.status === 'published' ? 'success' : 'warning'} status-badge`;
                           AdminUtils.showToast('Status updated successfully', 'success');
                       } else {
                           AdminUtils.showToast(response.message || 'Failed to update status', 'error');
                       }
                   })
                   .catch(error => {
                       AdminUtils.showToast('An error occurred', 'error');
                   });
           });
       });
   
       // Featured toggle
       document.querySelectorAll('.featured-badge').forEach(badge => {
           badge.addEventListener('click', function() {
               const postId = this.dataset.postId;
               
               AdminUtils.makeRequest(`/admin/blogs/toggle-featured/${postId}`, 'POST')
                   .then(response => {
                       if (response.success) {
                           this.textContent = response.is_featured ? 'Featured' : 'Regular';
                           this.className = `badge bg-${response.is_featured ? 'info' : 'secondary'} featured-badge`;
                           AdminUtils.showToast('Featured status updated successfully', 'success');
                       } else {
                           AdminUtils.showToast(response.message || 'Failed to update featured status', 'error');
                       }
                   })
                   .catch(error => {
                       AdminUtils.showToast('An error occurred', 'error');
                   });
           });
       });
   
       // Delete functionality
       let deletePostId = null;
       
       document.querySelectorAll('.delete-btn').forEach(btn => {
           btn.addEventListener('click', function() {
               deletePostId = this.dataset.postId;
               document.getElementById('postTitle').textContent = this.dataset.postTitle;
               new bootstrap.Modal(document.getElementById('deleteModal')).show();
           });
       });
   
       document.getElementById('confirmDelete')?.addEventListener('click', function() {
           if (deletePostId) {
               window.location.href = `/admin/blogs/delete/${deletePostId}`;
           }
       });
   
       // Bulk action form validation
       document.getElementById('bulkActionForm')?.addEventListener('submit', function(e) {
           const selectedPosts = document.querySelectorAll('.post-checkbox:checked');
           const bulkAction = document.querySelector('select[name="bulk_action"]').value;
           
           if (selectedPosts.length === 0) {
               e.preventDefault();
               AdminUtils.showToast('Please select at least one post', 'warning');
               return;
           }
           
           if (!bulkAction) {
               e.preventDefault();
               AdminUtils.showToast('Please select an action', 'warning');
               return;
           }
           
           if (!confirm(`Apply "${bulkAction}" to ${selectedPosts.length} selected post(s)?`)) {
               e.preventDefault();
           }
       });
   });
</script>
<?= $this->include('layouts/dashboard_footer') ?>