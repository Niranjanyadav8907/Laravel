@extends('layouts.admin')

@section('title', 'Payment Management')
@section('page-title', 'Payment Management')
@section('breadcrumb', 'Payment Management')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Payment Management</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 m-4">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Filter by User</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control filter-user-input" placeholder="Username or Email">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Filter by Plan</label>
                            <div class="input-group input-group-outline is-filled">
                                <select class="form-control filter-plan-select">
                                    <option value="">All Plans</option>
                                    @foreach($subscriptions as $sub)
                                        <option value="{{ $sub->plan_name }}">{{ $sub->plan_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Filter by Status</label>
                            <div class="input-group input-group-outline is-filled">
                                <select class="form-control filter-status-select">
                                    <option value="">All Statuses</option>
                                    <option value="Active">Active</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <div class="mb-3">
                            <i class="fas fa-sync refresh-payment-btn cursor-pointer" title="Refresh"></i>&nbsp;&nbsp;
                            <i class="fas fa-plus create-payment-modal-btn cursor-pointer" title="Add Manual Payment"></i>&nbsp;&nbsp;
                            <i class="fas fa-download export-payments-btn cursor-pointer" title="Export"></i>
                        </div>
                        
                        <table class="table payment-table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">User</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Plan</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Payment Status</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Payment Modal -->
<div class="modal fade payment-modal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title payment-modal-title">Add Manual Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="payment-form">
                    @csrf
                    <input type="hidden" name="payment_id" class="payment-id-input" value="">
                    <input type="hidden" name="user_id" class="user-id-input" value="">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control user-name-input" name="user_name_input"  
                                       autocomplete="off"
                                       onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <!-- User Suggestions Dropdown -->
                            <div class="user-suggestions-dropdown suggestions-dropdown" style="display: none;"></div>
                            <small class="text-danger error-text user_name_input_error"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">User Email</label>
                                <input type="email" class="form-control user-email-input" name="user_email_input" 
                                       onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text user_email_input_error"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Select Plan</label>
                                <select class="form-control plan-select" name="plan_id" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Plan</option>
                                    @foreach($subscriptions as $sub)
                                        <option value="{{ $sub->id }}" data-price="{{ $sub->price }}" data-duration="{{ $sub->duration }}">
                                            {{ $sub->plan_name }} - ${{ $sub->price }} / {{ $sub->duration }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-danger error-text plan_id_error"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Payment Status</label>
                                <select class="form-control payment-status-select" name="payment_status" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Status</option>
                                    <option value="Active" selected>Active</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <small class="text-danger error-text payment_status_error"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Payment Method (Optional)</label>
                                <input type="text" class="form-control payment-method-input" name="payment_method" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text payment_method_error"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Transaction ID (Optional)</label>
                                <input type="text" class="form-control transaction-id-input" name="transaction_id" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text transaction_id_error"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-payment-btn">Save Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- View Payment Details Modal -->
<div class="modal fade view-payment-modal" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body payment-details-content">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.content_header').hide();

    let searchTimeout;
    let filterTimeout;

    loadPaymentData();

    // ========== Auto-filter on input/select change ==========
    $('.filter-user-input').on('change', function() {
        loadPaymentData();
    });

    $('.filter-plan-select, .filter-status-select').on('change', function() {
        loadPaymentData();
    });

    $('.filter-plan-select, .filter-status-select').on('change', function() {
        loadPaymentData();
    });

    // ========== User Autocomplete Search via AJAX ==========
    $('.user-name-input, .user-email-input').on('keyup', function() {
        clearTimeout(searchTimeout);
        
        let searchTerm = $(this).val().trim();
        
        if (searchTerm.length < 2) {
            $('.user-suggestions-dropdown').hide();
            return;
        }

        searchTimeout = setTimeout(function() {
            searchUsers(searchTerm);
        }, 300);
    });

    function searchUsers(searchTerm) {
        $.ajax({
            url: "{{ route('payment.search.users') }}",
            type: "GET",
            data: { search: searchTerm },
            success: function(response) {
                if (response.status && response.users.length > 0) {
                    displayUserSuggestions(response.users);
                } else {
                    $('.user-suggestions-dropdown').hide();
                }
            },
            error: function() {
                $('.user-suggestions-dropdown').hide();
            }
        });
    }

    function displayUserSuggestions(users) {
        let html = '';
        
        users.forEach(user => {
            html += `
                <div class="suggestion-item" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}">
                    <strong>${escapeHtml(user.name)}</strong><br>
                    <small class="text-muted">${escapeHtml(user.email)}</small>
                </div>
            `;
        });

        $('.user-suggestions-dropdown').html(html).show();
    }

    // ========== Select User from Suggestions ==========
    $(document).on('click', '.suggestion-item', function() {
        let userId = $(this).data('id');
        let userName = $(this).data('name');
        let userEmail = $(this).data('email');

        $('.user-id-input').val(userId);
        $('.user-name-input').val(userName);
        $('.user-email-input').val(userEmail);
        
        focused(document.querySelector('.user-name-input'));
        focused(document.querySelector('.user-email-input'));
        
        $('.user-suggestions-dropdown').hide();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.user-name-input, .user-email-input, .user-suggestions-dropdown').length) {
            $('.user-suggestions-dropdown').hide();
        }
    });

    // ========== Add New Payment Button ==========
    $('.create-payment-modal-btn').on('click', function() {
        resetForm();
        $('.payment-modal-title').text('Add Manual Payment');
        $('.save-payment-btn').text('Save Payment');
        $('.payment-modal').modal('show');
    });

    // ========== Save/Update Payment ==========
    $(document).on('click', '.save-payment-btn', function() {
        showLoader();

        let form = document.querySelector('.payment-form');
        let formData = new FormData(form);

        $('.error-text').text('');

        $.ajax({
            url: "{{ route('add.payment.ajax') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.save-payment-btn').text('Please wait...').prop('disabled', true);
            },
            success: function(response) {
                hideLoader();
                if (response.status) {
                    showToaster('success', response.message);
                    resetForm();
                    $('.payment-modal').modal('hide');
                    loadPaymentData();
                } else {
                    showToaster('error', response.message);
                }
            },
            error: function(xhr) {
                hideLoader();
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    showToaster('error', 'Something went wrong!');
                }
            },
            complete: function() {
                $('.save-payment-btn')
                    .text($('.payment-id-input').val() ? 'Update Payment' : 'Save Payment')
                    .prop('disabled', false);
            }
        });
    });

    // ========== Delete Payment ==========
    $(document).on('click', '.delete-payment-btn', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this payment record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();

                $.ajax({
                    url: "{{ route('payment.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        hideLoader();
                        showToaster('success', response.message);
                        loadPaymentData();
                    },
                    error: function() {
                        hideLoader();
                        Swal.fire('Error!', 'Something went wrong during deletion.', 'error');
                    }
                });
            }
        });
    });

    // ========== Refresh Button ==========
    $(document).on('click', '.refresh-payment-btn', function() {
        $('.filter-user-input').val('');
        $('.filter-plan-select').val('');
        $('.filter-status-select').val('');
        loadPaymentData();
    });

    // ========== Renew Payment ==========
    $(document).on('click', '.renew-payment-btn', function() {
        var id = $(this).data('id');
        var userName = $(this).data('user');

        Swal.fire({
            title: 'Renew Subscription?',
            text: `Do you want to renew subscription for ${userName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, renew it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();

                $.ajax({
                    url: "{{ route('payment.renew') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        hideLoader();
                        if (response.status) {
                            showToaster('success', response.message);
                            loadPaymentData();
                        } else {
                            showToaster('error', response.message);
                        }
                    },
                    error: function() {
                        hideLoader();
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // ========== Cancel Payment ==========
    $(document).on('click', '.cancel-payment-btn', function() {
        var id = $(this).data('id');
        var userName = $(this).data('user');

        Swal.fire({
            title: 'Cancel Subscription?',
            text: `Do you want to cancel subscription for ${userName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();

                $.ajax({
                    url: "{{ route('payment.cancel') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        hideLoader();
                        if (response.status) {
                            showToaster('success', response.message);
                            loadPaymentData();
                        } else {
                            showToaster('error', response.message);
                        }
                    },
                    error: function() {
                        hideLoader();
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // ========== Approve Payment ==========
    $(document).on('click', '.approve-payment-btn', function() {
        var id = $(this).data('id');
        var userName = $(this).data('user');

        Swal.fire({
            title: 'Approve Payment?',
            text: `Do you want to approve payment for ${userName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();

                $.ajax({
                    url: "{{ route('payment.approve') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        hideLoader();
                        if (response.status) {
                            showToaster('success', response.message);
                            loadPaymentData();
                        } else {
                            showToaster('error', response.message);
                        }
                    },
                    error: function() {
                        hideLoader();
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // ========== View Payment Details ==========
    $(document).on('click', '.view-payment-btn', function() {
        var id = $(this).data('id');
        showLoader();

        $.ajax({
            url: "{{ route('payment.details') }}",
            type: "GET",
            data: { id: id },
            success: function(response) {
                hideLoader();
                if (response.status) {
                    $('.payment-details-content').html(response.html);
                    $('.view-payment-modal').modal('show');
                } else {
                    showToaster('error', response.message);
                }
            },
            error: function() {
                hideLoader();
                showToaster('error', 'Failed to load payment details');
            }
        });
    });

    // ========== Export Payments ==========
    $(document).on('click', '.export-payments-btn', function() {
        showLoader();
        
        var filters = {
            user: $('.filter-user-input').val(),
            plan: $('.filter-plan-select').val(),
            status: $('.filter-status-select').val()
        };

        window.location.href = "{{ route('payment.export') }}?" + $.param(filters);
        
        setTimeout(function() {
            hideLoader();
        }, 2000);
    });

    // ========== Load Payment Data ==========
    function loadPaymentData() {
        showLoader();

        var filters = {
            user: $('.filter-user-input').val(),
            plan: $('.filter-plan-select').val(),
            status: $('.filter-status-select').val()
        };

        $.ajax({
            url: "{{ route('payment.data') }}",
            type: "GET",
            data: filters,
            success: function(response) {
                let rows = '';
                
                if (response.length === 0) {
                    rows = `
                        <tr>
                            <td colspan="5" class="text-center">
                                <p class="text-sm text-secondary mb-0">No payment records found</p>
                            </td>
                        </tr>
                    `;
                } else {
                    response.forEach((payment, index) => {
                    let paymentTypeText = payment.payment_type === 'Manual' ? '<p class="text-xs mb-0">Manual</p>' : '';

                    rows += `
                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">${escapeHtml(payment.user_name)}</h6>
                                    <p class="text-xs text-secondary mb-0">${escapeHtml(payment.user_email)}</p>
                                    ${paymentTypeText}
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-sm bg-gradient-info">${escapeHtml(payment.plan_name)}</span></td>
                        <td>${getStatusBadge(payment.payment_status)}</td>
                        <td>
                            <div>
                                <p class="mb-0 text-sm text-success">Start: ${formatDateTime(payment.start_date)}</p>
                                <p class="mb-0 text-sm text-primary">End: ${formatDateTime(payment.end_date)}</p>
                            </div>
                        </td>
                        <td>${getActionButtons(payment)}</td>
                    </tr>`;
                });
                }

                $('.payment-table tbody').html(rows);
                hideLoader();
            },
            error: function(err) {
                hideLoader();
                console.error('Payment fetch error', err);
                showToaster('error', 'Failed to load payment data');
            }
        });
    }

    function getStatusBadge(status) {
        const statusConfig = {
            'Active': { color: 'success', text: 'Active' },
            'Expired': { color: 'danger', text: 'Expired' },
            'Pending': { color: 'warning', text: 'Pending' },
            'Cancelled': { color: 'secondary', text: 'Cancelled' }
        };

        const config = statusConfig[status] || { color: 'secondary', text: status };
        return `<span class="badge badge-sm bg-gradient-${config.color}">${config.text}</span>`;
    }

    function getActionButtons(payment) {
        let buttons = '';

        // Renew button
        if (payment.payment_status === 'Active' || payment.payment_status === 'Expired') {
            buttons += `
                <button class="btn btn-sm btn-warning renew-payment-btn mb-0" 
                        data-id="${payment.id}" 
                        data-user="${escapeHtml(payment.user_name)}"
                        title="Renew">
                    Renew
                </button> `;
        }

        // Approve button
        if (payment.payment_status === 'Pending') {
            buttons += `
                <button class="btn btn-sm btn-success approve-payment-btn mb-0" 
                        data-id="${payment.id}" 
                        data-user="${escapeHtml(payment.user_name)}"
                        title="Approve">
                    Approve
                </button> `;
        }

        // Cancel button
        if (payment.payment_status === 'Active' || payment.payment_status === 'Pending') {
            buttons += `
                <button class="btn btn-sm btn-danger cancel-payment-btn mb-0" 
                        data-id="${payment.id}" 
                        data-user="${escapeHtml(payment.user_name)}"
                        title="Cancel">
                    Cancel
                </button> `;
        }

        // Delete button 
        buttons += `
            <button class="btn btn-link text-danger delete-payment-btn mb-0" 
                    data-id="${payment.id}"
                    title="Delete">
                <i class="fas fa-trash"></i>
            </button>`;

        return buttons || '<span class="text-xs text-secondary">No actions</span>';
    }

    function formatDateTime(dateString) {
        if (!dateString) return '-';

        var dateObj = new Date(dateString);

        var options = { 
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };

        return dateObj.toLocaleString('en-US', options);
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, m => map[m]);
    }

    function resetForm() {
        $('.payment-form')[0].reset();
        $('.payment-id-input').val('');
        $('.user-id-input').val('');
        $('.user-suggestions-dropdown').hide();
        $('.error-text').text('');
        
        $('.payment-form').find('input, textarea, select').each(function() {
            defocused(this);
        });
    }
});
</script>

<style>
.cursor-pointer:hover {
    opacity: 0.7;
    transform: scale(1.1);
}

.badge {
    padding: 0.5em 0.75em;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    margin: 2px;
}

/* User Autocomplete Suggestions */
.suggestions-dropdown {
    position: absolute;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    width: 100%;
    margin-top: 5px;
}

.suggestion-item {
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s;
}

.suggestion-item:last-child {
    border-bottom: none;
}

.suggestion-item:hover {
    background-color: #f8f9fa;
}

.suggestion-item strong {
    color: #344767;
    font-size: 14px;
}

.suggestion-item small {
    color: #67748e;
    font-size: 12px;
}

/* Filter inputs styling */
.filter-user-input,
.filter-plan-select,
.filter-status-select {
    transition: border-color 0.3s ease;
}

.filter-user-input:focus,
.filter-plan-select:focus,
.filter-status-select:focus {
    border-color: #5e72e4;
    box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
}
</style>

@endsection