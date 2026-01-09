<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<div class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark"><?= $title ?></h1>
                    <p class="lead text-muted">Embark on a spiritual journey to sacred destinations</p>
                </div>
            </div>
        </div>

        <?php if (!empty($destinations)): ?>
            <div class="row">
                <?php foreach ($destinations as $destination): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($destination['image'])): ?>
                                <img src="<?= base_url($destination['image']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= esc($destination['name']) ?>"
                                     style="height: 250px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title"><?= esc($destination['name']) ?></h5>
                                    <?php if (!empty($destination['is_popular'])): ?>
                                        <span class="badge bg-warning text-dark">Popular</span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($destination['type_name'])): ?>
                                    <small class="text-muted mb-2">
                                        <i class="fas fa-tag"></i> <?= esc($destination['type_name']) ?>
                                    </small>
                                <?php endif; ?>
                                <p class="card-text flex-grow-1">
                                    <?= esc(substr(strip_tags($destination['description'] ?? ''), 0, 120)) ?>...
                                </p>
                                <div class="mt-auto">
                                    <a href="<?= base_url('/destinations/' . $destination['slug']) ?>" 
                                       class="btn btn-primary">
                                        Explore <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-pray fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">No spiritual destinations found</h3>
                <p class="text-muted">We're working on adding spiritual tour packages. Check back soon!</p>
                <a href="<?= base_url('/destinations') ?>" class="btn btn-primary">
                    View All Destinations
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>