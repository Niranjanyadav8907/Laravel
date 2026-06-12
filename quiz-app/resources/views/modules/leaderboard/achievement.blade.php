@extends('layouts.admin')

@section('title', 'Achievement')
@section('page-title', 'Achievement')
@section('breadcrumb', 'Achievement')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Achievement Management</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_achievement cursor-pointer" title="Refresh"></i>&nbsp;&nbsp;
                        <i class="fas fa-plus create_new_achievement_modal_button cursor-pointer" title="Add New Achievement"></i>&nbsp;&nbsp;
                        <i class="fas fa-sync cursor-pointer reward_sync" title="Reward Sync To User">Reward Sync</i>
                        <table class="table achievementTable align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Achievement</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Criteria Type</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Value</th>
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

<!-- Achievement Modal -->
<div class="modal fade" id="createAchievementModal" tabindex="-1" aria-labelledby="createAchievementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAchievementModalLabel">Add New Achievement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="add_achievement_form">
                    @csrf
                    <input type="hidden" name="achievement_id" id="achievement_id" value="">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text title_error"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Icon (Emoji)</label>
                                <input type="text" class="form-control" name="icon" id="icon" placeholder="🏆" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text icon_error"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="2" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                            </div>
                            <small class="text-danger error-text description_error"></small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Criteria Type</label>
                                <select class="form-control" name="criteria_type" id="criteria_type" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Type</option>
                                    <option value="quiz_completed">Quiz Completed</option>
                                    <option value="score_achieved">Score Achieved</option>
                                    <option value="time_based">Time Based</option>
                                    <option value="rank_based">Rank Based</option>
                                </select>
                            </div>
                            <small class="text-danger error-text criteria_type_error"></small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Criteria Value</label>
                                <input type="number" class="form-control" name="criteria_value" id="criteria_value" min="1" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text criteria_value_error"></small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Icon Background</label>
                                <input type="color" class="form-control" name="icon_bg_color" id="icon_bg_color" value="#fff3cd" style="height:45px;">
                            </div>
                            <small class="text-danger error-text icon_bg_color_error"></small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Status</option>
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <small class="text-danger error-text status_error"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary create_new_achievement">Save Achievement</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.content_header').hide();

    // Load achievements on page load
    achievementData();

    // ========== Add New Achievement Button Click ==========
    $('.create_new_achievement_modal_button').on('click', function() {
        resetForm();
        $('#createAchievementModalLabel').text('Add New Achievement');
        $('.create_new_achievement').text('Save Achievement');
        $('#createAchievementModal').modal('show');
    });

    // ========== Edit Achievement Button Click ==========
    $(document).on('click', '.edit_achievement', function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var description = $(this).data('description');
        var icon = $(this).data('icon');
        var iconBgColor = $(this).data('icon-bg');
        var criteriaType = $(this).data('criteria-type');
        var criteriaValue = $(this).data('criteria-value');
        var status = $(this).data('status');

        $('.error-text').text('');
        $('#achievement_id').val(id);
        $('#title').val(title);
        $('#description').val(description);
        $('#icon').val(icon);
        $('#icon_bg_color').val(iconBgColor);
        $('#criteria_type').val(criteriaType);
        $('#criteria_value').val(criteriaValue);
        $('#status').val(status);

        $('.add_achievement_form').find('input, textarea, select').each(function() {
            if ($(this).val()) {
                focused(this);
            }
        });

        $('#createAchievementModalLabel').text('Update Achievement');
        $('.create_new_achievement').text('Update Achievement');
        $('#createAchievementModal').modal('show');
    });
	
	$(document).on('click', '.reward_sync', function() {
		rewardSync();
    });
	
	function rewardSync(){
		showLoader();
		$.ajax({
			url: "{{ route('achievement.sync') }}",
			type: "POST",
			data: {
				id: "{{ Auth::user()->id }}",
				_token: "{{ csrf_token() }}"
			},
			success: function(response) {
				hideLoader();
				console.log(response);
				/* showToaster('success', response.message);
				achievementData(); */
			},
			error: function() {
				hideLoader();
				Swal.fire('Error!', 'Something went wrong during achievement sync.', 'error');
			}
		});
	}
    // ========== Save/Update Achievement ==========
    $(document).on('click', '.create_new_achievement', function() {
        showLoader();

        let form = document.querySelector('.add_achievement_form');
        let formData = new FormData(form);

        $('.error-text').text('');

        $.ajax({
            url: "{{ route('add.achievement.ajax') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.create_new_achievement').text('Please wait...').prop('disabled', true);
            },
            success: function(response) {
                hideLoader();
                if (response.status) {
                    showToaster('success', response.message);
                    resetForm();
                    $('#createAchievementModal').modal('hide');
                    achievementData();
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
                $('.create_new_achievement')
                    .text($('#achievement_id').val() ? 'Update Achievement' : 'Save Achievement')
                    .prop('disabled', false);
            }
        });
    });

    // ========== Delete Achievement (from action column) ==========
    $(document).on('click', '.delete_achievement', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this achievement!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();

                $.ajax({
                    url: "{{ route('achievement.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        hideLoader();
                        showToaster('success', response.message);
                        achievementData();
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
    $(document).on('click', '.refresh_achievement', function() {
        achievementData();
    });

    // ========== Update Status ==========
    $(document).on('change', '.update_status', function() {
        let status = $(this).val();
        let id = $(this).data('id');
        let $this = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change the status of this achievement!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();

                $.ajax({
                    url: "{{ route('achievement.update.status') }}",
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
                            achievementData();
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

    // ========== Fetch Achievement Data ==========
    function achievementData() {
        showLoader();

        $.get("{{ route('achievement.data') }}").done(function(response) {
            let rows = '';
            
            response.forEach(achievement => {
                const description = achievement.description ? achievement.description.substring(0, 50) + '...' : '-';
                
				let deleteButton = '';
				if(achievement.id !== 1 && achievement.id !== 2 && achievement.id !== 3 && achievement.id !== 4){
					deleteButton = `<i class="fas fa-trash text-danger cursor-pointer delete_achievement" data-id="${achievement.id}" title="Delete"></i>`;
				}
                rows += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="achievement-icon me-3" style="background: ${achievement.icon_bg_color};">
                                ${achievement.icon}
                            </div>
                            <div>
                                <h6 class="mb-0 text-sm">${achievement.title}</h6>
                                <p class="text-xs text-secondary mb-0">${description}</p>
                            </div>
                        </div>
                    </td>
                    <td><p class="text-sm">${formatCriteriaType(achievement.criteria_type)}</p></td>
                    <td><p class="text-sm font-weight-bold">${achievement.criteria_value}</p></td>
                    <td><div class="input-group input-group-outline is-filled">${statusUI(achievement.status, achievement.id)}</div></td>
                    <td>
                        <i class="fas fa-edit text-info cursor-pointer edit_achievement"
                           data-id="${achievement.id}"
                           data-title="${achievement.title}"
                           data-description="${achievement.description || ''}"
                           data-icon="${achievement.icon}"
                           data-icon-bg="${achievement.icon_bg_color}"
                           data-criteria-type="${achievement.criteria_type}"
                           data-criteria-value="${achievement.criteria_value}"
                           data-status="${achievement.status}"
                           title="Edit">
                        </i>
                        ${deleteButton}
                    </td>
                </tr>`;
            });

            $('.achievementTable tbody').html(rows);
            hideLoader();
        }).fail(function(err) {
            hideLoader();
            console.error('Achievement fetch error', err);
        });
    }

    function formatCriteriaType(type) {
        return type.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
    }

    function statusUI(status, id) {
        const colors = { Active: 'success', Inactive: 'danger' };
        let options = ['Active', 'Inactive'].map(s => 
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
        $('.add_achievement_form')[0].reset();
        $('#achievement_id').val('');
        $('.error-text').text('');
        $('#icon_bg_color').val('#fff3cd');
        
        $('.add_achievement_form').find('input, textarea, select').each(function() {
            defocused(this);
        });
    }
});
</script>

<style>
.achievement-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cursor-pointer {
    cursor: pointer;
    margin: 0 5px;
}

.cursor-pointer:hover {
    opacity: 0.7;
}
</style>

@endsection