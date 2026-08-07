<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - <?= date('Y-m-d') ?></title>
    <style>
        @page { margin: 20px; }
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .library-name { font-size: 20px; font-weight: bold; }
        .report-title { font-size: 16px; margin: 10px 0; color: #dc3545; }
        .print-date { font-size: 11px; margin-bottom: 15px; }
        .summary { margin: 15px 0; padding: 10px; background: #fff5f5; border: 1px solid #f5c6cb; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f8d7da; text-align: left; padding: 8px; border: 1px solid #f5c6cb; font-weight: bold; color: #721c24; }
        td { padding: 8px; border: 1px solid #f5c6cb; vertical-align: top; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #f5c6cb; font-size: 10px; text-align: center; color: #721c24; }
        .no-data { text-align: center; padding: 20px; font-style: italic; color: #666; }
        .book-cover { width: 40px; height: 60px; object-fit: cover; border: 1px solid #f5c6cb; }
        .overdue-days { color: #dc3545; font-weight: bold; }
        .urgency-high { background: #f8d7da; }
    </style>
</head>
<body>
    <div class="header">
        <div class="library-name"><?= $library_name ?></div>
        <div class="report-title"><?= $title ?></div>
        <div class="print-date">Printed on: <?= $print_date ?></div>
    </div>
    
    <div class="summary">
        <strong>URGENT ATTENTION REQUIRED</strong><br>
        Total Overdue Items: <strong><?= count($results) ?></strong> |
        As of: <?= date('F d, Y') ?>
    </div>
    
    <?php if(empty($results)): ?>
        <div class="no-data">No overdue books found. Good job!</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cover</th>
                    <th>Transaction ID</th>
                    <th>Book Details</th>
                    <th>Member</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Days Overdue</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php foreach($results as $row): ?>
                <?php
                    $dueDate = new DateTime($row['due_date']);
                    $today = new DateTime();
                    $daysOverdue = $today->diff($dueDate)->days;
                    $daysOverdue = $dueDate < $today ? $daysOverdue : 0;
                ?>
                <tr class="<?= $daysOverdue > 7 ? 'urgency-high' : '' ?>">
                    <td class="text-center"><?= $counter++ ?></td>
                    <td class="text-center">
                        <?php if(!empty($row['image'])): ?>
                            <img src="<?= base_url('uploads/books/' . $row['image']) ?>" 
                                 alt="Cover" 
                                 class="book-cover">
                        <?php else: ?>
                            <div style="width: 40px; height: 60px; border: 1px solid #f5c6cb; display: flex; align-items: center; justify-content: center;">
                                <span style="font-size: 10px;">No Image</span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>#<?= $row['id'] ?></td>
                    <td>
                        <strong><?= esc($row['title']) ?></strong><br>
                        <small>Author: <?= esc($row['author']) ?></small>
                    </td>
                    <td><?= esc($row['full_name']) ?></td>
                    <td><?= date('M d, Y', strtotime($row['borrow_date'])) ?></td>
                    <td class="overdue-days"><?= date('M d, Y', strtotime($row['due_date'])) ?></td>
                    <td class="overdue-days text-center">
                        <?= $daysOverdue ?> day(s)
                    </td>
                    <td class="overdue-days">OVERDUE</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="margin-top: 20px; padding: 10px; background: #fff3cd; border: 1px solid #ffeaa7;">
            <strong>Recommendations:</strong>
            <ul style="margin: 5px 0; padding-left: 20px;">
                <li>Contact members with overdue items immediately</li>
                <li>Items overdue >7 days require immediate follow-up</li>
                <li>Consider temporary borrowing suspension for repeat offenders</li>
            </ul>
        </div>
    <?php endif; ?>
    
    <div class="footer">
        <p>REQUIRES IMMEDIATE ACTION - Report generated by Digital Library System</p>
    </div>
    
<script>
// Auto print when page loads
window.onload = function() {
    // Give it a small delay to ensure content is loaded
    setTimeout(function() {
        window.print();
        
        // Check if print was cancelled or completed
        window.onafterprint = function() {
            // Close window after printing (or if print was cancelled)
            setTimeout(function() {
                window.close();
            }, 100);
        };
        
        // Fallback: close after 5 seconds if onafterprint doesn't fire
        setTimeout(function() {
            if (!window.closed) {
                window.close();
            }
        }, 5000);
        
    }, 500); // 0.5 second delay to ensure everything loads
};

// Handle browser back button or manual close
window.onbeforeunload = function() {
    return null; // No warning message when closing
};

// Alternative approach for browsers that don't support onafterprint well
let beforePrint = function() {
    console.log('Print started...');
};

let afterPrint = function() {
    console.log('Print completed...');
    setTimeout(function() {
        window.close();
    }, 100);
};

// Webkit browsers
if (window.matchMedia) {
    let mediaQueryList = window.matchMedia('print');
    mediaQueryList.addListener(function(mql) {
        if (mql.matches) {
            beforePrint();
        } else {
            afterPrint();
        }
    });
}

// Add a manual close button for users
document.addEventListener('DOMContentLoaded', function() {
    // Create close button
    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '✕ Close Window';
    closeBtn.style.cssText = `
        position: fixed;
        top: 10px;
        right: 10px;
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        z-index: 10000;
        display: none; /* Hide by default, show only if needed */
    `;
    closeBtn.onclick = function() {
        window.close();
    };
    document.body.appendChild(closeBtn);
    
    // Show close button after 3 seconds if still open
    setTimeout(function() {
        if (!window.closed) {
            closeBtn.style.display = 'block';
        }
    }, 3000);
});
</script>
</body>
</html>