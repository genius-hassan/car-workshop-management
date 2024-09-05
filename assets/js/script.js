jQuery(document).ready(function ($) {
    // Page navigation handler
    $(document).off('click', '.list-group-item-action').on('click', '.list-group-item-action', function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadDashboardPage(page);
    });

    function loadDashboardPage(page) {
        $.ajax({
            url: cwm_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'cwm_form_handler',
                page: page
            },
            success: function (response) {
                $('#cwm-dashboard-content').html(response);
            }
        });
    }

    // Modal show handlers
    $(document).off('click', '.btn-add-new-customer').on('click', '.btn-add-new-customer', function (e) {
        e.preventDefault();
        $('#addCustomerModal').modal('show');
    });

    $(document).off('click', '.btn-add-new-vendor').on('click', '.btn-add-new-vendor', function (e) {
        e.preventDefault();
        $('#addVendorModal').modal('show');
    });

    $(document).off('click', '.btn-add-new-invoice').on('click', '.btn-add-new-invoice', function (e) {
        e.preventDefault();
        $('#addInvoiceModal').modal('show');
    });

    // Reset forms when modals are hidden
    $('#addCustomerModal, #addVendorModal, #addInvoiceModal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('#new-customer-fields').hide(); // Hide new customer fields
    });

    // Handle form submissions
    $(document).off('submit', '#cwm-add-customer-form, #cwm-add-vendor-form, #cwm-add-invoice-form').on('submit', '#cwm-add-customer-form, #cwm-add-vendor-form, #cwm-add-invoice-form', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var dataType = $(this).attr('id').split('-')[2]; // 'customer', 'vendor', or 'invoice'

        $.ajax({
            url: cwm_ajax.ajax_url,
            type: 'POST',
            data: formData + '&action=cwm_save_data&data_type=' + dataType,
            success: function (response) {
                if (response.success) {
                    alert(response.data.message);
                    $('#' + 'add' + dataType.charAt(0).toUpperCase() + dataType.slice(1) + 'Modal').modal('hide');
                    loadDashboardPage(dataType + 's');
                } else {
                    alert('Error: ' + response.data.message);
                }
            }
        });
    });

    // Handle "New Customer" selection within Invoice Form
    $(document).off('change', '#invoice_customer').on('change', '#invoice_customer', function () {
        if ($(this).val() === 'new_customer') {
            $('#new-customer-fields').show();
        } else {
            $('#new-customer-fields').hide();
        }
    });

    // Add new item input fields
    let itemIndex = 1;
    $(document).off('click', '#add-invoice-item').on('click', '#add-invoice-item', function () {
        itemIndex++;
        const vendorOptions = $('#vendor_1').html(); // Fetch existing vendor options dynamically
        const newItemFields = `
            <tr>
                <td><input type="text" class="form-control" name="item_descriptions[]" required></td>
                <td>
                    <select name="vendors[]" class="form-control">
                        ${vendorOptions}
                    </select>
                </td>
                <td><input type="number" class="form-control vendor-premium" name="vendor_premiums[]" step="0.01"></td>
                <td><input type="number" class="form-control rate" name="rates[]" step="0.01" required></td>
                <td><input type="number" class="form-control quantity" name="quantities[]" required></td>
                <td><input type="number" class="form-control line-total" name="line_totals[]" readonly></td>
                <td><button type="button" class="btn btn-sm btn-danger btn-remove-item">x</button></td>
            </tr>
        `;
        $('#invoice-items-container').append(newItemFields);
    });

    // Handle removing item input fields
    $(document).off('click', '.btn-remove-item').on('click', '.btn-remove-item', function () {
        $(this).closest('tr').remove();
        updateGrandTotal(); // Recalculate grand total after removing an item
    });

    // Update line total and grand total dynamically
    $(document).off('input', '.rate, .quantity').on('input', '.rate, .quantity', function () {
        const row = $(this).closest('tr');
        const rate = parseFloat(row.find('.rate').val()) || 0;
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const lineTotal = rate * quantity;
        row.find('.line-total').val(lineTotal.toFixed(2));
        updateGrandTotal();
    });

    function updateGrandTotal() {
        let grandTotal = 0;
        $('.line-total').each(function () {
            grandTotal += parseFloat($(this).val()) || 0;
        });
        $('#grand-total').text(grandTotal.toFixed(2));
    }

    // Initial load of the dashboard
    loadDashboardPage('dashboard');
});
