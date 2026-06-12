@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'Settings Add')
@section('breadcrumb', 'Settings Add') 

@section('content')


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Settings List</h6>
                    </div>
                </div>
                
                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_setting cursor-pointer"></i>&nbsp;&nbsp;
                        <i class="fas fa-plus create_new_setting_modal_button cursor-pointer"></i>
						<table class="table settingTable" style="width:100%;">
							<thead>
								<tr>	
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">#Id</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Key</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Value</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Type</th>
									<th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Group</th>
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

<div class="modal fade" id="createSettingModal" tabindex="-1" aria-labelledby="createStiingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createStiingsModalLabel">Add New Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="settingForm">
                    @csrf
					<input type="hidden" class="id" name="id">

                    <div class="row">
						
						<div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Setting Label</label>
                                <input type="text" class="form-control label" name="label" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text label_error"></small>
                        </div>
						
						<div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Setting Key</label>
                                <input type="text" class="form-control setting_key" name="setting_key" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text setting_key_error"></small>
                        </div>
						
						<div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Setting value</label>
                                <input type="text" class="form-control value" name="value" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text value_error"></small>
                        </div>
						
						<div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Type</label>
                                <select class="form-control type" name="type" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="text">Text</option>
									<option value="number">Number</option>
									<option value="image">Image</option>
									<option value="boolean">Boolean</option>
                                </select>
                            </div>
                            <small class="text-danger error-text type_error"></small>
                        </div>
						
						<div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Group</label>
                                <input type="text" class="form-control setting_group" name="setting_group" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text value_error"></small>
                        </div>

						<div class="col-md-4 mb-2">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Public</label>
                                <select class="form-control is_public" name="is_public" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="1">Yes</option>
									<option value="0">No</option>
                                </select>
                            </div>
                            <small class="text-danger error-text type_error"></small>
                        </div>
						
						<div class="col-md-12 mb-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Description</label>
                                <textarea class="form-control description" name="description" id="description" rows="3" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                            </div>
                            <small class="text-danger error-text description_error"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary create_new_setting">Save Setting</button>
            </div>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
(function($) {
    $(document).ready(function() {
        var createSettingModal = new bootstrap.Modal(document.getElementById('createSettingModal'));
        var settingTable = $('.settingTable').DataTable({
            responsive: true,
            columns: [
                { orderable: true },
                { orderable: true },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[0, 'desc']]
        });
    
        $('.create_new_setting_modal_button').on('click', function() {
            resetForm(); 
			$('.id').val('');
            $('#createStiingsModalLabel').text('Add New Setting');
            $('.create_new_setting').text('Save Setting');
            createSettingModal.show(); 
        });
        
        $(document).on('click', '.edit_setting', function() {
			$('.error-text').text('');

			$('.id').val($(this).data('id'));

			$('.setting_key').val($(this).data('key'));
			$('.value').val($(this).data('value'));
			$('.type').val($(this).data('type'));
			$('.setting_group').val($(this).data('group'));
			$('.label').val($(this).data('label'));
			$('.description').val($(this).data('description'));

			$('.is_public').val($(this).data('public'));

			$('#settingForm').find('input, textarea, select').each(function () {
				if($(this).val()) {
					focused(this);
				}
			});

			$('#createStiingsModalLabel').text('Update Setting');
			$('.create_new_setting').text('Update Setting');

			createSettingModal.show();
        });
        

        $(document).on('click', '.create_new_setting', function () {
            showLoader();

            let form = document.querySelector('#settingForm');
            let formData = new FormData(form);

            $('.error-text').text('');

            $.ajax({ 
                url: "{{ route('add.settings.ajax') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.create_new_setting').text('Please wait...').prop('disabled', true);
                },success: function (response) {
                    hideLoader();
                    if (response.status) {
                        showToaster('success', response.message);
                        resetForm();
                        createSettingModal.hide(); 
                        settingsData();
                    } else {
                        showToaster('error', response.message);
                    }
                },

                error: function (xhr) {
                    hideLoader();
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        showToaster('error', 'Something went wrong!');
                    }
                },

                complete: function () {
                    $('.create_new_setting')
                        .text($('#quiz_id').val() ? 'Update Setting' : 'Save Setting')
                        .prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.refresh_setting', function () {
            settingsData();
        });
        
		
		settingsData();
		let categoryList = [];
		
		function settingsData() {
			showLoader();

			$.get("{{ route('settings.data') }}").done(function (response) {

				let rows = '';

				if (response.status && response.settings.length > 0) {

					response.settings.forEach(setting => {

						rows += `
						<tr>
							<td>${setting.id ?? ''}</td>
							<td>${setting.setting_key ?? ''}</td>
							<td>${setting.value ?? ''}</td>
							<td>${setting.type ?? ''}</td>
							<td>${setting.setting_group ?? ''}</td>
							<td>
								<i class="fas fa-edit text-info cursor-pointer edit_setting"
									data-id="${setting.id}"
									data-key="${setting.setting_key}"
									data-value="${setting.value}"
									data-type="${setting.type}"
									data-group="${setting.setting_group}"
									data-label="${setting.label}"
									data-description="${setting.description}"
									data-public="${setting.is_public}">
								</i>

								<i class="fas fa-trash text-danger cursor-pointer delete_setting"
									data-id="${setting.id}">
								</i>
							</td>
						</tr>`;
					});

				} else {
					rows = `<tr><td colspan="5" class="text-center">No settings found</td></tr>`;
				}

				if ($.fn.DataTable.isDataTable('.settingTable')) {
					$('.settingTable').DataTable().destroy();
				}

				$('.settingTable tbody').html(rows);

				$('.settingTable').DataTable({
					responsive: true,
					pageLength: 10,
					order: [[0, 'desc']]
				});

				hideLoader();
			})
			.fail(function (err) {
				hideLoader();
				console.error('Settings fetch error', err);
			});
		}
		
        
        $(document).on('click', '.delete_setting', function () {
            var id = $(this).data('id');
			var btn = $(this);
			
            Swal.fire({
                title: 'Are you sure delete this setting?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();

                    $.ajax({
                        url: "{{ route('quiz.settings') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            showToaster('success', response.message);
                            btn.closest('tr').remove(); 
                        },
                        error: function () {
                            hideLoader();
                            Swal.fire(
                                'Error!',
                                'Something went wrong during deletion.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
         

        function resetForm() {
            $('#settingForm')[0].reset();
            $('#quiz_id').val('');
            $('.error-text').text('');
            
            $('#settingForm').find('input, textarea, select').each(function () {
                defocused(this);
            });
        }
        
    });
})(jQuery);
</script>

@endsection