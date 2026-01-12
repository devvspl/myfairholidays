<?php include APPPATH . 'Views/layouts/dashboard_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Contact Message Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/contacts') ?>">Contact Messages</a></li>
                        <li class="breadcrumb-item active">Message Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Message from <?= esc($contact['name']) ?></h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('/admin/contacts') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Message Content -->
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><?= esc($contact['subject']) ?></h5>
                                        <?php
                                        $statusClass = [
                                            'new' => 'bg-warning',
                                            'read' => 'bg-info',
                                            'replied' => 'bg-success',
                                            'closed' => 'bg-secondary'
                                        ];
                                        ?>
                                        <span class="badge <?= $statusClass[$contact['status']] ?? 'bg-secondary' ?>">
                                            <?= ucfirst($contact['status']) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="message-content">
                                        <?= nl2br(esc($contact['message'])) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Reply Section -->
                            <div class="card border mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Quick Reply</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>To:</strong> 
                                        <a href="mailto:<?= esc($contact['email']) ?>" class="text-decoration-none">
                                            <?= esc($contact['email']) ?>
                                        </a>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Subject:</strong> Re: <?= esc($contact['subject']) ?>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex">
                                        <a href="mailto:<?= esc($contact['email']) ?>?subject=Re: <?= urlencode($contact['subject']) ?>&body=Dear <?= urlencode($contact['name']) ?>,%0D%0A%0D%0AThank you for contacting My Fair Holidays.%0D%0A%0D%0A" 
                                           class="btn btn-primary">
                                            <i class="fas fa-reply me-1"></i> Reply via Email
                                        </a>
                                        <a href="tel:<?= esc($contact['phone']) ?>" class="btn btn-success">
                                            <i class="fas fa-phone me-1"></i> Call <?= esc($contact['phone']) ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Contact Information -->
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Contact Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Name:</strong><br>
                                        <?= esc($contact['name']) ?>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Email:</strong><br>
                                        <a href="mailto:<?= esc($contact['email']) ?>" class="text-decoration-none">
                                            <?= esc($contact['email']) ?>
                                        </a>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Phone:</strong><br>
                                        <a href="tel:<?= esc($contact['phone']) ?>" class="text-decoration-none">
                                            <?= esc($contact['phone']) ?>
                                        </a>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Date Received:</strong><br>
                                        <?= date('F j, Y g:i A', strtotime($contact['created_at'])) ?>
                                    </div>
                                    <?php if (!empty($contact['ip_address'])): ?>
                                    <div class="mb-3">
                                        <strong>IP Address:</strong><br>
                                        <small class="text-muted"><?= esc($contact['ip_address']) ?></small>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Status Management -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Status Management</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Update Status:</label>
                                        <select id="statusSelect" class="form-select">
                                            <option value="new" <?= $contact['status'] === 'new' ? 'selected' : '' ?>>New</option>
                                            <option value="read" <?= $contact['status'] === 'read' ? 'selected' : '' ?>>Read</option>
                                            <option value="replied" <?= $contact['status'] === 'replied' ? 'selected' : '' ?>>Replied</option>
                                            <option value="closed" <?= $contact['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                                        </select>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="button" id="updateStatus" class="btn btn-primary btn-sm">
                                            <i class="fas fa-save me-1"></i> Update Status
                                        </button>
                                        <a href="<?= base_url('/admin/contacts/delete/' . $contact['id']) ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure you want to delete this message?')">
                                            <i class="fas fa-trash me-1"></i> Delete Message
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="printMessage()">
                                            <i class="fas fa-print me-1"></i> Print Message
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                                            <i class="fas fa-copy me-1"></i> Copy Message
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update Status
    document.getElementById('updateStatus').addEventListener('click', function() {
        const status = document.getElementById('statusSelect').value;
        const contactId = <?= $contact['id'] ?>;
        
        fetch(`<?= base_url('/admin/contacts/update-status/') ?>${contactId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                status: status,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status updated successfully');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    });
});

function printMessage() {
    const printContent = `
        <h2>Contact Message</h2>
        <p><strong>From:</strong> <?= esc($contact['name']) ?> (<?= esc($contact['email']) ?>)</p>
        <p><strong>Phone:</strong> <?= esc($contact['phone']) ?></p>
        <p><strong>Subject:</strong> <?= esc($contact['subject']) ?></p>
        <p><strong>Date:</strong> <?= date('F j, Y g:i A', strtotime($contact['created_at'])) ?></p>
        <hr>
        <div><?= nl2br(esc($contact['message'])) ?></div>
    `;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Contact Message - <?= esc($contact['name']) ?></title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h2 { color: #333; }
                    hr { margin: 20px 0; }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

function copyToClipboard() {
    const messageText = `
From: <?= esc($contact['name']) ?> (<?= esc($contact['email']) ?>)
Phone: <?= esc($contact['phone']) ?>
Subject: <?= esc($contact['subject']) ?>
Date: <?= date('F j, Y g:i A', strtotime($contact['created_at'])) ?>

Message:
<?= esc($contact['message']) ?>
    `.trim();
    
    navigator.clipboard.writeText(messageText).then(() => {
        alert('Message copied to clipboard');
    }).catch(err => {
        console.error('Failed to copy: ', err);
        alert('Failed to copy message');
    });
}
</script>

<?php include APPPATH . 'Views/layouts/dashboard_footer.php'; ?>