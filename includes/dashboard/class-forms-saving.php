<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CWM_Forms_Saving {

    /**
     * Render the Add Customer form.
     */
    public static function render_add_customer_form() {
        ?>
        <form id="cwm-add-customer-form" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                <div class="invalid-feedback">Please provide a name.</div>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone">
            </div>
            <div id="vehicles-container">
                <div class="form-group">
                    <label for="vehicle_number_1">Vehicle Number</label>
                    <input type="text" class="form-control vehicle-number" id="vehicle_number_1" name="vehicle_numbers[]" required>
                    <div class="invalid-feedback">Please provide a vehicle number.</div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-vehicle">Add Another Vehicle</button>
            <button type="submit" class="btn btn-primary">Add Customer</button>
        </form>
        <?php
    }

    /**
     * Render the Add Vendor form.
     */
    public static function render_add_vendor_form() {
        ?>
        <form id="cwm-add-vendor-form" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="vendor_name">Vendor Name</label>
                <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
                <div class="invalid-feedback">Please provide a name.</div>
            </div>
            <div class="form-group">
                <label for="vendor_address">Address</label>
                <input type="text" class="form-control" id="vendor_address" name="vendor_address">
            </div>
            <div class="form-group">
                <label for="vendor_phone">Phone</label>
                <input type="tel" class="form-control" id="vendor_phone" name="vendor_phone">
            </div>
            <button type="submit" class="btn btn-primary">Add Vendor</button>
        </form>
        <?php
    }

    /**
     * Render the Add Invoice form.
     */
    public static function render_add_invoice_form() {
		?>
		<form id="cwm-add-invoice-form" class="needs-validation" novalidate>
			<div class="form-group">
				<label for="invoice_customer">Customer</label>
				<select id="invoice_customer" name="invoice_customer" class="form-control" required>
					<option value="">Select a Customer</option>
					<?php
					$customers = get_posts(array('post_type' => 'customer', 'numberposts' => -1));
					if ($customers) {
						foreach ($customers as $customer) {
							echo '<option value="' . esc_attr($customer->ID) . '">' . esc_html($customer->post_title) . '</option>';
						}
					}
					?>
					<option value="new_customer">New Customer</option> <!-- Add New Customer Option -->
				</select>
				<div class="invalid-feedback">Please select a customer.</div>
			</div>

			<!-- New Customer Fields (Initially Hidden) -->
			<div id="new-customer-fields" style="display: none;">
				<div class="form-group">
					<label for="new_customer_name">Customer Name</label>
					<input type="text" class="form-control" id="new_customer_name" name="new_customer_name">
				</div>
				<div class="form-group">
					<label for="new_customer_address">Address</label>
					<input type="text" class="form-control" id="new_customer_address" name="new_customer_address">
				</div>
				<div class="form-group">
					<label for="new_customer_phone">Phone</label>
					<input type="tel" class="form-control" id="new_customer_phone" name="new_customer_phone">
				</div>
			</div>

			<!-- Table Structure for Invoice Items -->
			<table class="table">
				<thead>
					<tr>
						<th>Item Description</th>
						<th>Vendor</th>
						<th>Vendor Premium</th>
						<th>Rate</th>
						<th>Quantity</th>
						<th>Line Total</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="invoice-items-container">
					<tr>
						<td><input type="text" class="form-control" name="item_descriptions[]" required></td>
						<td>
							<select id="vendor_1" name="vendors[]" class="form-control">
								<option value="">Select a Vendor</option>
								<?php
								$vendors = get_posts(array('post_type' => 'vendor', 'numberposts' => -1));
								if ($vendors) {
									foreach ($vendors as $vendor) {
										echo '<option value="' . esc_attr($vendor->ID) . '">' . esc_html($vendor->post_title) . '</option>';
									}
								}
								?>
							</select>
						</td>
						<td><input type="number" class="form-control vendor-premium" name="vendor_premiums[]" step="0.01"></td>
						<td><input type="number" class="form-control rate" name="rates[]" step="0.01" required></td>
						<td><input type="number" class="form-control quantity" name="quantities[]" required></td>
						<td><input type="number" class="form-control line-total" name="line_totals[]" readonly></td>
						<td><button type="button" class="btn btn-sm btn-danger btn-remove-item">x</button></td>
					</tr>
				</tbody>
			</table>
			<button type="button" class="btn btn-secondary" id="add-invoice-item">Add Another Item</button>
			<button type="submit" class="btn btn-primary">Save Invoice</button>
		</form>
		<?php
	}




    /**
     * Handle all data submissions.
     */
    public static function handle_data_submission($data_type, $data) {
        $post_type = $data_type; // Matches the post type to the data type

        $post_data = array(
            'post_type'   => $post_type,
            'post_status' => 'publish',
            'meta_input'  => array(),
        );

        switch ($data_type) {
            case 'customer':
                $post_data['post_title'] = sanitize_text_field($data['customer_name']);
                $post_data['meta_input'] = array(
                    'address' => sanitize_text_field($data['address']),
                    'phone'   => sanitize_text_field($data['phone']),
                    'vehicle_numbers' => array_map('sanitize_text_field', $data['vehicle_numbers']),
                );
                break;

            case 'vendor':
                $post_data['post_title'] = sanitize_text_field($data['vendor_name']);
                $post_data['meta_input'] = array(
                    'address' => sanitize_text_field($data['vendor_address']),
                    'phone'   => sanitize_text_field($data['vendor_phone']),
                );
                break;

            case 'invoice':
                $post_data['post_title'] = 'Invoice for Customer ID ' . sanitize_text_field($data['invoice_customer']);
                $post_data['meta_input'] = array(
                    'customer_id'        => sanitize_text_field($data['invoice_customer']),
                    'item_descriptions'  => array_map('sanitize_text_field', $data['item_descriptions']),
                    'vendors'            => array_map('sanitize_text_field', $data['vendors']),
                    'vendor_premiums'    => array_map('sanitize_text_field', $data['vendor_premiums']),
                    'rates'              => array_map('sanitize_text_field', $data['rates']),
                    'quantities'         => array_map('sanitize_text_field', $data['quantities']),
                );
                break;
        }

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            wp_send_json_error(array('message' => 'Failed to save ' . $data_type . ' data: ' . $post_id->get_error_message()));
        } else {
            wp_send_json_success(array('message' => ucfirst($data_type) . ' saved successfully'));
        }
    }
}
