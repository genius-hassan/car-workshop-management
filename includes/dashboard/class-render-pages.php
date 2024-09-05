<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CWM_Render_Pages {

    /**
     * Render the Customers Page.
     */
    public static function render_customers_page() {
        ?>
        <h3>Customers</h3>
        <button class="btn btn-success mb-3 btn-add-new-customer">Add New Customer</button>
        <table id="customer-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Vehicles</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $customers = get_posts(array('post_type' => 'customer', 'numberposts' => -1));
                if ($customers) {
                    foreach ($customers as $index => $customer) {
                        $vehicles = get_post_meta($customer->ID, 'vehicle_numbers', true);
                        $vehicles_list = is_array($vehicles) ? implode(', ', $vehicles) : $vehicles;
                        ?>
                        <tr>
                            <td><?php echo esc_html($index + 1); ?></td>
                            <td><?php echo esc_html($customer->post_title); ?></td>
                            <td><?php echo esc_html(get_post_meta($customer->ID, 'address', true)); ?></td>
                            <td><?php echo esc_html(get_post_meta($customer->ID, 'phone', true)); ?></td>
                            <td><?php echo esc_html($vehicles_list); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5">No customers found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Render the Vendors Page.
     */
    public static function render_vendors_page() {
        ?>
        <h3>Vendors</h3>
        <button class="btn btn-success mb-3 btn-add-new-vendor">Add New Vendor</button>
        <table id="vendor-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vendor Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $vendors = get_posts(array('post_type' => 'vendor', 'numberposts' => -1));
                if ($vendors) {
                    foreach ($vendors as $index => $vendor) {
                        ?>
                        <tr>
                            <td><?php echo esc_html($index + 1); ?></td>
                            <td><?php echo esc_html($vendor->post_title); ?></td>
                            <td><?php echo esc_html(get_post_meta($vendor->ID, 'address', true)); ?></td>
                            <td><?php echo esc_html(get_post_meta($vendor->ID, 'phone', true)); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="4">No vendors found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Render the Invoices Page.
     */
    public static function render_invoices_page() {
        ?>
        <h3>Invoices</h3>
        <button class="btn btn-success mb-3 btn-add-new-invoice">Add New Invoice</button>
        <table id="invoice-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $invoices = get_posts(array('post_type' => 'invoice', 'numberposts' => -1));
                if ($invoices) {
                    foreach ($invoices as $index => $invoice) {
                        $customer_id = get_post_meta($invoice->ID, 'customer_id', true);
                        $customer_name = get_the_title($customer_id);
                        $total_amount = 0; // Calculate total amount based on items

                        ?>
                        <tr>
                            <td><?php echo esc_html($index + 1); ?></td>
                            <td><?php echo esc_html($customer_name); ?></td>
                            <td><?php echo esc_html(get_the_date('', $invoice->ID)); ?></td>
                            <td><?php echo esc_html($total_amount); ?></td>
                            <td>
                                <button class="btn btn-secondary">Print</button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5">No invoices found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
    }
}
