<?= $this->include('layouts/dashboard_header') ?>
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="page-title-box">
            <h4 class="page-title"><?= $title ?></h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active">Video Gallery</li>
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
      <!-- Total Videos -->
      <div class="col-xl-2 col-md-4 col-sm-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded">
                           <i data-lucide="video" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Total Videos</p>
                     <h4 class="mb-0"><?= $stats['total'] ?? 0 ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Active -->
      <div class="col-xl-2 col-md-4 col-sm-6">
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
                     <h4 class="mb-0 text-success"><?= $stats['active'] ?? 0 ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Homepage -->
      <div class="col-xl-2 col-md-4 col-sm-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-info-subtle text-info rounded">
                           <i data-lucide="home" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Homepage</p>
                     <h4 class="mb-0 text-info"><?= $stats['homepage'] ?? 0 ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- YouTube -->
      <div class="col-xl-2 col-md-4 col-sm-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-danger-subtle text-danger rounded">
                           <i data-lucide="youtube" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">YouTube</p>
                     <h4 class="mb-0 text-danger"><?= $stats['youtube'] ?? 0 ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- MP4 -->
      <div class="col-xl-2 col-md-4 col-sm-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-purple-subtle text-purple rounded">
                           <i data-lucide="file-video" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">MP4</p>
                     <h4 class="mb-0 text-purple"><?= $stats['mp4'] ?? 0 ?></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Trashed -->
      <div class="col-xl-2 col-md-4 col-sm-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                     <div class="avatar-sm">
                        <div class="avatar-title bg-warning-subtle text-warning rounded">
                           <i data-lucide="trash-2" class="fs-20"></i>
                        </div>
                     </div>
                  </div>
                  <div class="flex-grow-1">
                     <p class="text-muted mb-1">Trashed</p>
                     <h4 class="mb-0 text-warning"><?= $stats['trashed'] ?? 0 ?></h4>
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
                  <h4 class="card-title mb-0">Video Gallery</h4>
                  <div class="btn-group">
                     <a href="<?= base_url('/admin/videos/trash') ?>" class="btn btn-outline-warning btn-sm">
                     <i data-lucide="trash-2" class="me-1"></i> Recycle Bin (<?= $stats['trashed'] ?? 0 ?>)
                     </a>
                     <a href="<?= base_url('/admin/videos/create') ?>" class="btn btn-primary btn-sm">
                     <i data-lucide="plus" class="me-1"></i> Add New Video
                     </a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <!-- Bulk Actions -->
               <?php if (!empty($videos)): ?>
               <form id="bulkForm" method="post" action="<?= base_url('/admin/videos/bulk-action') ?>">
                  <?= csrf_field() ?>
                  <div class="row mb-3">
                     <div class="col-md-6">
                        <div class="d-flex align-items-center">
                           <select name="bulk_action" class="form-select me-2" style="width: auto;">
                              <option value="">Bulk Actions</option>
                              <option value="activate">Activate Selected</option>
                              <option value="deactivate">Deactivate Selected</option>
                              <option value="delete">Move to Trash</option>
                           </select>
                           <button type="submit" class="btn btn-outline-secondary btn-sm">Apply</button>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="input-group">
                           <input type="text" class="form-control" placeholder="Search videos..." id="searchInput">
                           <button class="btn btn-outline-secondary" type="button">
                           <i data-lucide="search"></i>
                           </button>
                        </div>
                     </div>
                  </div>
                  <?php endif; ?>
                  <!-- Videos Grid -->
                  <div class="row" id="videosGrid">
                     <?php if (!empty($videos)): ?>
                     <?php foreach ($videos as $video): ?>
                     <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card video-card">
                           <div class="position-relative">
                              <?php
        $thumbnailUrl = '';
        if ($video['video_type'] === 'youtube') {
            $thumbnailUrl = "https://img.youtube.com/vi/{$video['video_id']}/maxresdefault.jpg";
        } else {
            $thumbnailUrl = $video['thumbnail'] ? base_url($video['thumbnail']) : base_url('assets/images/small/img-1.jpg');
        }
        ?>
                              <img src="<?= $thumbnailUrl ?>" 
                                 class="card-img-top" 
                                 alt="<?= esc($video['title']) ?>" 
                                 style="height: 180px; object-fit: cover;"
                                 onerror="this.src='<?= base_url('assets/images/small/img-1.jpg') ?>'">
                              <div class="position-absolute top-0 start-0 p-2">
                                 <input type="checkbox" name="selected_ids[]" value="<?= $video['id'] ?>" class="form-check-input">
                              </div>
                              <div class="position-absolute top-0 end-0 p-2">
                                 <span class="badge bg-<?= $video['video_type'] === 'youtube' ? 'danger' : 'purple' ?>">
                                 <?= strtoupper($video['video_type']) ?>
                                 </span>
                                 <?php if ($video['is_homepage']): ?>
                                 <span class="badge bg-info ms-1">Homepage</span>
                                 <?php endif; ?>
                              </div>
                              <div class="position-absolute bottom-0 start-0 p-2">
                                 <span class="badge <?= $video['status'] === 'active' ? 'bg-success' : 'bg-warning' ?>">
                                 <?= ucfirst($video['status']) ?>
                                 </span>
                              </div>
                              <!-- Play button overlay -->
                              <div class="position-absolute top-50 start-50 translate-middle">
                                 <div class="play-button-container">
                                    <button type="button" class="btn play-video-btn" 
                                       data-video-type="<?= $video['video_type'] ?>"
                                       data-video-url="<?= esc($video['video_url']) ?>"
                                       data-video-title="<?= esc($video['title']) ?>">
                                       <div class="play-triangle"></div>
                                    </button>
                                 </div>
                              </div>
                           </div>
                           <div class="card-body p-3">
                              <h6 class="card-title mb-1" title="<?= esc($video['title']) ?>">
                                 <?= esc(strlen($video['title']) > 30 ? substr($video['title'], 0, 30) . '...' : $video['title']) ?>
                              </h6>
                              <small class="text-muted">
                              <?= date('M j, Y', strtotime($video['created_at'])) ?>
                              </small>
                              <?php if ($video['description']): ?>
                              <p class="text-muted small mt-1 mb-2">
                                 <?= esc(strlen($video['description']) > 60 ? substr($video['description'], 0, 60) . '...' : $video['description']) ?>
                              </p>
                              <?php endif; ?>
                              <div class="mt-2">
                                 <div class="btn-group btn-group-sm w-100">
                                    <a href="<?= base_url('/admin/videos/edit/' . $video['id']) ?>" 
                                       class="btn btn-outline-primary" title="Edit">
                                    <i data-lucide="edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-info play-video" 
                                       title="Play"
                                       data-video-type="<?= $video['video_type'] ?>"
                                       data-video-url="<?= esc($video['video_url']) ?>"
                                       data-video-title="<?= esc($video['title']) ?>">
                                    <i data-lucide="play"></i>
                                    </button>
                                    <a href="<?= base_url('/admin/videos/toggle-homepage/' . $video['id']) ?>" 
                                       class="btn btn-outline-<?= $video['is_homepage'] ? 'warning' : 'info' ?>" 
                                       title="<?= $video['is_homepage'] ? 'Remove from Homepage' : 'Add to Homepage' ?>">
                                    <i data-lucide="home"></i>
                                    </a>
                                    <a href="<?= base_url('/admin/videos/delete/' . $video['id']) ?>" 
                                       class="btn btn-outline-danger" 
                                       title="Delete"
                                       onclick="return confirm('Are you sure you want to move this video to trash?')">
                                    <i data-lucide="trash-2"></i>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php endforeach; ?>
                     <?php else: ?>
                     <!-- Empty state when no videos -->
                     <div class="col-12 text-center py-5">
                        <i data-lucide="video" class="text-muted" style="width: 48px; height: 48px;"></i>
                        <h5 class="mt-3 text-muted">No videos found</h5>
                        <p class="text-muted">Add your first video to get started.</p>
                        <a href="<?= base_url('/admin/videos/create') ?>" class="btn btn-primary">
                        <i data-lucide="plus" class="me-1"></i> Add New Video
                        </a>
                     </div>
                     <?php endif; ?>
                  </div>
                  <?php if (!empty($videos)): ?>
               </form>
               <?php endif; ?>
               <!-- Pagination -->
               <?php if (isset($pager)): ?>
               <div class="d-flex justify-content-center">
                  <?= $pager->links() ?>
               </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Video Player Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="videoTitle">Video Player</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body p-0">
            <div id="videoContainer" class="ratio ratio-16x9">
               <!-- Video content will be loaded here -->
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       // Video player functionality
       document.querySelectorAll('.play-video-btn').forEach(button => {
           button.addEventListener('click', function() {
               const videoType = this.getAttribute('data-video-type');
               const videoUrl = this.getAttribute('data-video-url');
               const videoTitle = this.getAttribute('data-video-title');
               
               document.getElementById('videoTitle').textContent = videoTitle;
               const container = document.getElementById('videoContainer');
               
               if (videoType === 'youtube') {
                   // Extract YouTube video ID
                   const videoId = extractYouTubeId(videoUrl);
                   container.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allowfullscreen></iframe>`;
               } else {
                   // MP4 video
                   container.innerHTML = `<video controls autoplay class="w-100 h-100"><source src="${videoUrl}" type="video/mp4">Your browser does not support the video tag.</video>`;
               }
               
               new bootstrap.Modal(document.getElementById('videoModal')).show();
           });
       });
   
       // Also handle the small play buttons in the action bar
       document.querySelectorAll('.play-video').forEach(button => {
           button.addEventListener('click', function() {
               const videoType = this.getAttribute('data-video-type');
               const videoUrl = this.getAttribute('data-video-url');
               const videoTitle = this.getAttribute('data-video-title');
               
               document.getElementById('videoTitle').textContent = videoTitle;
               const container = document.getElementById('videoContainer');
               
               if (videoType === 'youtube') {
                   // Extract YouTube video ID
                   const videoId = extractYouTubeId(videoUrl);
                   container.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allowfullscreen></iframe>`;
               } else {
                   // MP4 video
                   container.innerHTML = `<video controls autoplay class="w-100 h-100"><source src="${videoUrl}" type="video/mp4">Your browser does not support the video tag.</video>`;
               }
               
               new bootstrap.Modal(document.getElementById('videoModal')).show();
           });
       });
   
       // Clear video when modal is closed
       document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
           document.getElementById('videoContainer').innerHTML = '';
       });
   
       // Bulk actions
       const bulkForm = document.getElementById('bulkForm');
       if (bulkForm) {
           bulkForm.addEventListener('submit', function(e) {
               const action = this.querySelector('select[name="bulk_action"]').value;
               const selected = this.querySelectorAll('input[name="selected_ids[]"]:checked');
               
               if (!action) {
                   e.preventDefault();
                   alert('Please select an action');
                   return;
               }
               
               if (selected.length === 0) {
                   e.preventDefault();
                   alert('Please select at least one video');
                   return;
               }
               
               if (action === 'delete') {
                   if (!confirm(`Are you sure you want to move ${selected.length} video(s) to trash?`)) {
                       e.preventDefault();
                   }
               }
           });
       }
   
       // Select all functionality
       const selectAllBtn = document.createElement('button');
       selectAllBtn.type = 'button';
       selectAllBtn.className = 'btn btn-outline-secondary btn-sm ms-2';
       selectAllBtn.innerHTML = '<i data-lucide="check-square"></i> Select All';
       selectAllBtn.addEventListener('click', function() {
           const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
           const allChecked = Array.from(checkboxes).every(cb => cb.checked);
           checkboxes.forEach(cb => cb.checked = !allChecked);
           this.innerHTML = allChecked ? '<i data-lucide="check-square"></i> Select All' : '<i data-lucide="square"></i> Deselect All';
       });
       
       const bulkActions = document.querySelector('.d-flex.align-items-center');
       if (bulkActions) {
           bulkActions.appendChild(selectAllBtn);
       }
   
       // Search functionality
       const searchInput = document.getElementById('searchInput');
       if (searchInput) {
           searchInput.addEventListener('keyup', function(e) {
               if (e.key === 'Enter') {
                   performSearch();
               }
           });
       }
   
       function performSearch() {
           const searchTerm = searchInput.value.toLowerCase();
           const videoCards = document.querySelectorAll('.video-card');
           
           videoCards.forEach(card => {
               const title = card.querySelector('.card-title').textContent.toLowerCase();
               const parent = card.closest('.col-xl-3, .col-lg-4, .col-md-6');
               
               if (title.includes(searchTerm)) {
                   parent.style.display = '';
               } else {
                   parent.style.display = 'none';
               }
           });
       }
   
       function extractYouTubeId(url) {
           const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
           const matches = url.match(regex);
           return matches ? matches[1] : null;
       }
   });
</script>
<?= $this->include('layouts/dashboard_footer') ?>