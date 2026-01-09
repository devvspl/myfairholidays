<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<div class="py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/destinations') ?>">Destinations</a></li>
                <?php if (!empty($destination['type_name'])): ?>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/destinations/type/' . url_title($destination['type_name'], '-', true)) ?>">
                            <?= esc($destination['type_name']) ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?= esc($destination['name']) ?></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <!-- Main Content -->
                <div class="card shadow-sm mb-4">
                    <?php if (!empty($destination['image'])): ?>
                        <img src="<?= base_url($destination['image']) ?>" 
                             class="card-img-top" 
                             alt="<?= esc($destination['name']) ?>"
                             style="height: 400px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h1 class="card-title display-5"><?= esc($destination['name']) ?></h1>
                            <?php if (!empty($destination['is_popular'])): ?>
                                <span class="badge bg-warning text-dark fs-6">Popular Destination</span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <?php if (!empty($destination['type_name'])): ?>
                                <span class="badge bg-primary me-2">
                                    <i class="fas fa-tag"></i> <?= esc($destination['type_name']) ?>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($destination['parent_name'])): ?>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-map-marker-alt"></i> <?= esc($destination['parent_name']) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <h3>About <?= esc($destination['name']) ?></h3>
                            <p class="lead"><?= nl2br(esc($destination['description'] ?? '')) ?></p>
                        </div>

                        <?php if (!empty($destination['content'])): ?>
                            <div class="mb-4">
                                <h3>Detailed Information</h3>
                                <div class="content">
                                    <?= nl2br(esc($destination['content'])) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($destination['latitude']) && !empty($destination['longitude'])): ?>
                            <div class="mb-4">
                                <h3>Location</h3>
                                <p><i class="fas fa-map-marker-alt text-danger"></i> 
                                   Coordinates: <?= $destination['latitude'] ?>, <?= $destination['longitude'] ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Sidebar -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Plan Your Trip</h5>
                        <p class="card-text">Ready to explore <?= esc($destination['name']) ?>? Get a personalized quote for your trip.</p>
                        <a href="<?= base_url('/quote') ?>" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane"></i> Request Quote
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Need Help?</h5>
                        <p class="card-text">Our travel experts are here to help you plan the perfect trip.</p>
                        <a href="<?= base_url('/contact') ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-phone"></i> Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Destinations -->
        <?php if (!empty($relatedDestinations)): ?>
            <div class="mt-5">
                <h3 class="mb-4">Related Destinations</h3>
                <div class="row">
                    <?php foreach ($relatedDestinations as $related): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <?php if (!empty($related['image'])): ?>
                                    <img src="<?= base_url($related['image']) ?>" 
                                         class="card-img-top" 
                                         alt="<?= esc($related['name']) ?>"
                                         style="height: 200px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title"><?= esc($related['name']) ?></h6>
                                    <p class="card-text flex-grow-1 small">
                                        <?= esc(substr(strip_tags($related['description'] ?? ''), 0, 80)) ?>...
                                    </p>
                                    <a href="<?= base_url('/destinations/' . $related['slug']) ?>" 
                                       class="btn btn-sm btn-outline-primary mt-auto">
                                        Learn More
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>