@extends('layouts.admin')

@section('title', 'Subscription Plans')
@section('page-title', 'Subscription Plans')
@section('breadcrumb', 'Subscription Plans')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Subscription Plans Management</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_subscription cursor-pointer" title="Refresh"></i>&nbsp;&nbsp;
                        <i class="fas fa-plus create_new_subscription_modal_button cursor-pointer" title="Add New Plan"></i>
                        <table class="table subscriptionTable align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Plan Name</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Price</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Duration</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Action</th>
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

<!-- Subscription Modal -->
<div class="modal fade" id="createSubscriptionModal" tabindex="-1" aria-labelledby="createSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSubscriptionModalLabel">Add New Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="add_subscription_form">
                    @csrf
                    <input type="hidden" name="subscription_id" id="subscription_id" value="">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Plan Name</label>
                                <input type="text" class="form-control" name="plan_name" id="plan_name" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text plan_name_error"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Price ($)</label>
                                <input type="number" class="form-control" name="price" id="price" step="0.01" min="0" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text price_error"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Duration</label>
                                <select class="form-control" name="duration" id="duration" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Duration</option>
                                    <option value="month" selected>Monthly</option>
                                    <option value="year">Yearly</option>
                                    <option value="lifetime">Lifetime</option>
                                </select>
                            </div>
                            <small class="text-danger error-text duration_error"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Features</label>
                                <textarea class="form-control" name="features" id="features" rows="3" placeholder="Enter features" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                            </div>
                            <small class="text-danger error-text features_error"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Status</option>
                                    <option value="Active" selected>Active</option>
                                    <option value="Disabled">Disabled</option>
                                </select>
                            </div>
                            <small class="text-danger error-text status_error"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary create_new_subscription">Save Plan</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.content_header').hide();

    subscriptionData();

    // ========== Add New Subscription Button Click ==========
    $('.create_new_subscription_modal_button').on('click', function() {
        resetForm();
        $('#createSubscriptionModalLabel').text('Add New Plan');
        $('.create_new_subscription').text('Save Plan');
        $('#createSubscriptionModal').modal('show');
    });

    // ========== Edit Subscription Button Click ==========
    $(document).on('click', '.edit_subscription', function() {
        var id = $(this).data('id');
        var planName = $(this).data('plan-name');
        var price = $(this).data('price');
        var duration = $(this).data('duration');
        var features = $(this).data('features');
        var status = $(this).data('status');

        $('.error-text').text('');
        $('#subscription_id').val(id);
        $('#plan_name').val(planName);
        $('#price').val(price);
        $('#duration').val(duration);
        $('#features').val(features);
        $('#status').val(status);

        $('.add_subscription_form').find('input, textarea, select').each(function() {
            if ($(this).val()) {
                focused(this);
            }
        });

        $('#createSubscriptionModalLabel').text('Update Plan');
        $('.create_new_subscription').text('Update Plan');
        $('#createSubscriptionModal').modal('show');
    });

    // ========== Save/Update Subscription ==========
    $(document).on('click', '.create_new_subscription', function() {
        showLoader();

        let form = document.querySelector('.add_subscription_form');
        let formData = new FormData(form);

        $('.error-text').text('');

        $.ajax({
            url: "{{ route('add.subscription.ajax') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.create_new_subscription').text('Please wait...').prop('disabled', true);
            },
            success: function(response) {
                hideLoader();
                if (response.status) {
                    showToaster('success', response.message);
                    resetForm();
                    $('#createSubscriptionModal').modal('hide');
                    subscriptionData();
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
                $('.create_new_subscription')
                    .text($('#subscription_id').val() ? 'Update Plan' : 'Save Plan')
                    .prop('disabled', false);
            }
        });
    });

    // ========== Delete Subscription ==========
    $(document).on('click', '.delete_subscription', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this subscription plan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();

                $.ajax({
                    url: "{{ route('subscription.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        hideLoader();
                        showToaster('success', response.message);
                        subscriptionData();
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
    $(document).on('click', '.refresh_subscription', function() {
        subscriptionData();
    });

    // ========== Update Status (Achievement pattern) ==========
    $(document).on('change', '.update_status', function() {
        let status = $(this).val();
        let id = $(this).data('id');
        let $this = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change the status of this subscription plan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();

                $.ajax({
                    url: "{{ route('subscription.update.status') }}",
                    type: "POST",
                    data: {
                        id: id,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        hideLoader();
                        if (response.status) {
                            showToaster('success', response.message);
                            subscriptionData();
                        } else {
                            showToaster('error', response.message);
                            $this.val($this.data('prev'));
                        }
                    },
                    error: function() {
                        hideLoader();
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                        $this.val($this.data('prev'));
                    }
                });
            } else {
                $this.val($this.data('prev'));
            }
        });
    });

    $(document).on('focus', '.update_status', function() {
        $(this).data('prev', $(this).val());
    });

    // ========== Fetch Subscription Data ==========
    function subscriptionData() {
        showLoader();

        $.get("{{ route('subscription.data') }}").done(function(response) {
            let rows = '';
            response.reverse().forEach(subscription => {
                const features = subscription.features ? subscription.features.substring(0, 60) + '...' : '-';
                const priceDisplay = subscription.price == 0 ? 'Free' : '$' + parseFloat(subscription.price).toFixed(2);
                
                rows += `
                <tr>
                    <td>
                        <h6 class="mb-0 text-sm">${subscription.plan_name}</h6>
                        <p class="text-xs text-secondary mb-0">${features}</p>
                    </td>
                    <td><p class="text-sm font-weight-bold">${priceDisplay}</p></td>
                    <td><p class="text-sm">${formatDuration(subscription.duration)}</p></td>
                    <td><div class="input-group input-group-outline is-filled">${statusUI(subscription.status, subscription.id)}</div></td>
                    <td>
                        <i class="fas fa-edit text-info cursor-pointer edit_subscription"
                           data-id="${subscription.id}"
                           data-plan-name="${subscription.plan_name}"
                           data-price="${subscription.price}"
                           data-duration="${subscription.duration}"
                           data-features="${subscription.features || ''}"
                           data-status="${subscription.status}"
                           title="Edit">
                        </i>
                        <i class="fas fa-trash text-danger cursor-pointer delete_subscription" 
                           data-id="${subscription.id}"
                           title="Delete">
                        </i>
                    </td>
                </tr>`;
            });

            $('.subscriptionTable tbody').html(rows);
            hideLoader();
        }).fail(function(err) {
            hideLoader();
            console.error('Subscription fetch error', err);
        });
    }

    function formatDuration(duration) {
        const durations = {
            'month': 'Monthly',
            'year': 'Yearly',
            'lifetime': 'Lifetime'
        };
        return durations[duration] || duration;
    }

    function statusUI(status, id) {
        const colors = { Active: 'success', Disabled: 'danger' };
        let options = ['Active', 'Disabled'].map(s => 
            `<option ${s === status ? 'selected' : ''}>${s}</option>`
        ).join('');

        return `
            <select class="form-control update_status border-${colors[status]}" 
                    data-id="${id}" 
                    style="border-top: 2px solid var(--bs-${colors[status]});">
                ${options}
            </select>
        `;
    }

    function resetForm() {
        $('.add_subscription_form')[0].reset();
        $('#subscription_id').val('');
        $('.error-text').text('');
        $('#duration').val('month');
        
        $('.add_subscription_form').find('input, textarea, select').each(function() {
            defocused(this);
        });
    }
});
</script>

<style>
.cursor-pointer {
    cursor: pointer;
    margin: 0 5px;
}

.cursor-pointer:hover {
    opacity: 0.7;
}
</style>

@endsection