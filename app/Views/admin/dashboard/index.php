<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
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

    <!-- Quick Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Total Visitors</p>
                            <h4 class="fw-bold text-primary mb-0"><?= number_format($visitor_stats['total_visits']) ?></h4>
                            <small class="text-muted">Last 30 days</small>
                        </div>
                        <div>
                            <i data-lucide="users" class="fs-32 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Unique Visitors</p>
                            <h4 class="fw-bold text-info mb-0"><?= number_format($visitor_stats['unique_visitors']) ?></h4>
                            <small class="text-muted">Unique IPs</small>
                        </div>
                        <div>
                            <i data-lucide="user-check" class="fs-32 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Mobile Visits</p>
                            <h4 class="fw-bold text-success mb-0"><?= number_format($visitor_stats['mobile_visits']) ?></h4>
                            <small class="text-muted"><?= $visitor_stats['total_visits'] > 0 ? round(($visitor_stats['mobile_visits'] / $visitor_stats['total_visits']) * 100, 1) : 0 ?>% of total</small>
                        </div>
                        <div>
                            <i data-lucide="smartphone" class="fs-32 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Desktop Visits</p>
                            <h4 class="fw-bold text-warning mb-0"><?= number_format($visitor_stats['desktop_visits']) ?></h4>
                            <small class="text-muted"><?= $visitor_stats['total_visits'] > 0 ? round(($visitor_stats['desktop_visits'] / $visitor_stats['total_visits']) * 100, 1) : 0 ?>% of total</small>
                        </div>
                        <div>
                            <i data-lucide="monitor" class="fs-32 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Analytics Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">📈 Visitor Analytics</h4>
                    <div>
                        <select id="analyticsFilter" class="form-select form-select-sm">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="60">Last 60 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div id="visitorChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Details -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">🔝 Top Pages</h4>
                </div>
                <div class="card-body">
                    <div id="topPagesContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">🌐 Browser & Platform Stats</h4>
                </div>
                <div class="card-body">
                    <div id="browserPlatformContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Total Content</p>
                            <h4 class="fw-bold text-primary mb-0"><?= $quick_stats['total_content'] ?></h4>
                            <small class="text-muted">Blog Posts</small>
                        </div>
                        <div>
                            <i data-lucide="file-text" class="fs-32 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Total Destinations</p>
                            <h4 class="fw-bold text-info mb-0"><?= $quick_stats['total_destinations'] ?></h4>
                            <small class="text-muted">Travel Destinations</small>
                        </div>
                        <div>
                            <i data-lucide="map-pin" class="fs-32 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Total Bookings</p>
                            <h4 class="fw-bold text-success mb-0"><?= $quick_stats['total_bookings'] ?></h4>
                            <small class="text-muted">Completed</small>
                        </div>
                        <div>
                            <i data-lucide="check-circle" class="fs-32 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Pending Testimonials</p>
                            <h4 class="fw-bold text-warning mb-0"><?= $quick_stats['pending_testimonials'] ?></h4>
                            <small class="text-muted">Need Approval</small>
                        </div>
                        <div>
                            <i data-lucide="clock" class="fs-32 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">📊 Content Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Blog Stats -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-3">�  Blog Management</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Posts</span>
                                <span class="fw-bold"><?= $stats['blogs']['total'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Published</span>
                                <span class="text-success"><?= $stats['blogs']['published'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Draft</span>
                                <span class="text-warning"><?= $stats['blogs']['draft'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Featured</span>
                                <span class="text-info"><?= $stats['blogs']['featured'] ?></span>
                            </div>
                        </div>

                        <!-- Destinations Stats -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-3">🌍 Destinations</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Destinations</span>
                                <span class="fw-bold"><?= $stats['destinations']['total'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Active</span>
                                <span class="text-success"><?= $stats['destinations']['active'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Countries</span>
                                <span class="text-primary"><?= $stats['destinations']['countries'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Cities</span>
                                <span class="text-info"><?= $stats['destinations']['cities'] ?></span>
                            </div>
                        </div>

                        <!-- Itineraries Stats -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-3">🗺️ Itineraries</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Packages</span>
                                <span class="fw-bold"><?= $stats['itineraries']['total'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Published</span>
                                <span class="text-success"><?= $stats['itineraries']['published'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Featured</span>
                                <span class="text-info"><?= $stats['itineraries']['featured'] ?></span>
                            </div>
                        </div>

                        <!-- Payments Stats -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-3">💳 Payments</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Payments</span>
                                <span class="fw-bold"><?= $stats['payments']['total'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Completed</span>
                                <span class="text-success"><?= $stats['payments']['completed'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Pending</span>
                                <span class="text-warning"><?= $stats['payments']['pending'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- Testimonials Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">⭐ Testimonials</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Testimonials</span>
                        <span class="fw-bold"><?= $stats['testimonials']['total'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Approved</span>
                        <span class="text-success"><?= $stats['testimonials']['approved'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Pending</span>
                        <span class="text-warning"><?= $stats['testimonials']['pending'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Featured</span>
                        <span class="text-info"><?= $stats['testimonials']['featured'] ?></span>
                    </div>
                    <?php if ($stats['testimonials']['pending'] > 0): ?>
                        <div class="alert alert-warning">
                            <small><i data-lucide="alert-triangle" class="me-1"></i> 
                            <?= $stats['testimonials']['pending'] ?> testimonials need your attention</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Stats -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">💰 Payments</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Transactions</span>
                        <span class="fw-bold"><?= $stats['payments']['total'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Completed</span>
                        <span class="text-success"><?= $stats['payments']['completed'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Pending</span>
                        <span class="text-warning"><?= $stats['payments']['pending'] ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Revenue</span>
                        <span class="fw-bold text-success">$<?= number_format($stats['payments']['total_amount'], 2) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">🕒 Recent Activities</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_activities)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_activities as $activity): ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-soft-<?= 
                                                    $activity['type'] === 'blog' ? 'primary' : 
                                                    ($activity['type'] === 'booking' ? 'success' :
                                                    ($activity['type'] === 'hotel' ? 'info' :
                                                    ($activity['type'] === 'destination' ? 'purple' :
                                                    ($activity['type'] === 'itinerary' ? 'cyan' : 
                                                    ($activity['type'] === 'testimonial' ? 'warning' :
                                                    ($activity['type'] === 'contact' ? 'secondary' :
                                                    ($activity['type'] === 'payment' ? 'success' : 'dark'))))))) ?>">
                                                    <?php
                                                    $icons = [
                                                        'blog' => '📝',
                                                        'booking' => '📅',
                                                        'hotel' => '🏨',
                                                        'destination' => '🌍',
                                                        'itinerary' => '🗺️',
                                                        'testimonial' => '⭐',
                                                        'contact' => '✉️',
                                                        'payment' => '💳'
                                                    ];
                                                    echo $icons[$activity['type']] ?? '📌';
                                                    ?>
                                                    <?= ucfirst($activity['type']) ?>
                                                </span>
                                            </td>
                                            <td><?= esc($activity['title']) ?></td>
                                            <td><?= ucfirst($activity['action']) ?></td>
                                            <td>
                                                <span class="badge badge-soft-<?= 
                                                    in_array($activity['status'], ['published', 'approved', 'active', 'confirmed', 'completed', 'paid']) ? 'success' : 
                                                    (in_array($activity['status'], ['pending', 'new']) ? 'warning' : 
                                                    (in_array($activity['status'], ['draft', 'inactive']) ? 'secondary' : 'danger')) ?>">
                                                    <?= ucfirst($activity['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y g:i A', strtotime($activity['date'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i data-lucide="inbox" class="fs-48 text-muted mb-3"></i>
                            <p class="text-muted">No recent activities found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let visitorChart = null;
    
    // Load initial analytics
    loadVisitorAnalytics(30);
    
    // Filter change handler
    document.getElementById('analyticsFilter').addEventListener('change', function() {
        loadVisitorAnalytics(this.value);
    });
    
    function loadVisitorAnalytics(days) {
        // Show loading state
        document.getElementById('topPagesContent').innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';
        document.getElementById('browserPlatformContent').innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';
        
        fetch('<?= base_url('/admin/dashboard/visitor-analytics') ?>?days=' + days)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Analytics data:', data); // Debug log
                
                // Update chart
                updateVisitorChart(data.trends || []);
                
                // Update top pages
                updateTopPages(data.topPages || []);
                
                // Update browser/platform stats
                updateBrowserPlatformStats(data.browserStats || [], data.platformStats || []);
            })
            .catch(error => {
                console.error('Error loading analytics:', error);
                document.getElementById('visitorChart').innerHTML = '<div class="alert alert-danger">Error loading analytics data. Please try again.</div>';
                document.getElementById('topPagesContent').innerHTML = '<div class="alert alert-danger">Error loading data</div>';
                document.getElementById('browserPlatformContent').innerHTML = '<div class="alert alert-danger">Error loading data</div>';
            });
    }
    
    function updateVisitorChart(trends) {
        // Handle empty or undefined data
        if (!trends || trends.length === 0) {
            document.getElementById('visitorChart').innerHTML = '<div class="text-center py-5 text-muted">No visitor data available for this period</div>';
            return;
        }
        
        const dates = trends.map(item => item.date);
        const visits = trends.map(item => parseInt(item.visits));
        
        const options = {
            series: [{
                name: 'Visits',
                data: visits
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: dates,
                labels: {
                    formatter: function(value) {
                        const date = new Date(value);
                        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return Math.round(value);
                    }
                }
            },
            colors: ['#3b7ddd'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                }
            },
            tooltip: {
                x: {
                    format: 'dd MMM yyyy'
                }
            }
        };
        
        if (visitorChart) {
            visitorChart.destroy();
        }
        
        visitorChart = new ApexCharts(document.querySelector("#visitorChart"), options);
        visitorChart.render();
    }
    
    function updateTopPages(topPages) {
        let html = '';
        
        if (topPages.length === 0) {
            html = '<div class="text-center py-4 text-muted">No data available</div>';
        } else {
            html = '<div class="table-responsive"><table class="table table-sm table-hover mb-0">';
            html += '<thead class="table-light"><tr><th>Page</th><th class="text-end">Visits</th></tr></thead><tbody>';
            
            topPages.forEach(page => {
                const title = page.page_title || page.page_url;
                const shortTitle = title.length > 50 ? title.substring(0, 50) + '...' : title;
                html += `<tr>
                    <td><small>${escapeHtml(shortTitle)}</small></td>
                    <td class="text-end"><span class="badge bg-primary-subtle text-primary">${page.visit_count}</span></td>
                </tr>`;
            });
            
            html += '</tbody></table></div>';
        }
        
        document.getElementById('topPagesContent').innerHTML = html;
    }
    
    function updateBrowserPlatformStats(browserStats, platformStats) {
        let html = '<div class="row">';
        
        // Browser stats
        html += '<div class="col-md-6"><h6 class="fw-semibold mb-3">Browsers</h6>';
        if (browserStats.length === 0) {
            html += '<p class="text-muted">No data</p>';
        } else {
            browserStats.slice(0, 5).forEach(browser => {
                html += `<div class="d-flex justify-content-between mb-2">
                    <span>${escapeHtml(browser.browser)}</span>
                    <span class="badge bg-info-subtle text-info">${browser.count}</span>
                </div>`;
            });
        }
        html += '</div>';
        
        // Platform stats
        html += '<div class="col-md-6"><h6 class="fw-semibold mb-3">Platforms</h6>';
        if (platformStats.length === 0) {
            html += '<p class="text-muted">No data</p>';
        } else {
            platformStats.slice(0, 5).forEach(platform => {
                html += `<div class="d-flex justify-content-between mb-2">
                    <span>${escapeHtml(platform.platform)}</span>
                    <span class="badge bg-success-subtle text-success">${platform.count}</span>
                </div>`;
            });
        }
        html += '</div></div>';
        
        document.getElementById('browserPlatformContent').innerHTML = html;
    }
    
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>