<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CWM_Modal_Boxes {

    /**
     * Render all modals for adding customers, vendors, and invoices.
     */
    public function render_modals() {
        ?>
        <!-- Add New Customer Modal -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php CWM_Forms_Saving::render_add_customer_form(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Vendor Modal -->
        <div class="modal fade" id="addVendorModal" tabindex="-1" aria-labelledby="addVendorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVendorModalLabel">Add New Vendor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php CWM_Forms_Saving::render_add_vendor_form(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Invoice Modal -->
        <div class="modal fade" id="addInvoiceModal" tabindex="-1" aria-labelledby="addInvoiceModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl"> <!-- Use 'modal-xl' to make the modal extra large -->
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addInvoiceModalLabel">Add New Invoice</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<?php CWM_Forms_Saving::render_add_invoice_form(); ?>
						<div class="text-end">
							<strong>Grand Total: <span id="grand-total">0.00</span></strong> <!-- Display grand total -->
						</div>
					</div>
				</div>
			</div>
		</div>


        <?php
    }
}
