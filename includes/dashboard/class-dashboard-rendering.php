<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CWM_Dashboard_Rendering {

    /**
     * Render the main dashboard layout.
     */
    public function render_dashboard() {
        ob_start();
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" data-page="dashboard">Dashboard</a>
                        <a href="#" class="list-group-item list-group-item-action" data-page="invoices">Invoices</a>
                        <a href="#" class="list-group-item list-group-item-action" data-page="customers">Customers</a>
                        <a href="#" class="list-group-item list-group-item-action" data-page="vendors">Vendors</a>
                        <a href="#" class="list-group-item list-group-item-action" data-page="ledgers">Ledgers</a>
                    </div>
                </div>
                <div class="col-md-9" id="cwm-dashboard-content">
                    <!-- Content loaded via AJAX will be displayed here -->
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
