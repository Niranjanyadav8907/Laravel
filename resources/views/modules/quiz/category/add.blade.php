@extends('layouts.admin')
@section('title', 'Quiz Category')
@section('page-title', 'Quiz Category')
@section('breadcrumb', 'Quiz Category') 
@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
/* ── Bulk delete bar ── */
#category_bulk_delete_bar {
    display: none;
    align-items: center;
    gap: 10px;
    background: #fff5fb;
    border: 1.5px solid #f0c0dd;
    border-radius: 6px;
    padding: 7px 14px;
    margin-bottom: 10px;
}
#category_bulk_delete_bar span {
    font-size: 13px;
    font-weight: 600;
    color: #c0156e;
}
#category_bulk_delete_bar button {
    background: #e91e8c;
    border: none;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 16px;
    border-radius: 5px;
    text-transform: uppercase;
    letter-spacing: .4px;
    cursor: pointer;
    transition: background .2s;
}
#category_bulk_delete_bar button:hover { background: #c4186f; }

/* checkbox style */
.category-checkbox, #select_all_categories {
    width: 16px;
    height: 16px;
    accent-color: #e91e8c;
    cursor: pointer;
}

/* ── FIX: blank column issue ── */
.quizCategoryTable th:first-child,
.quizCategoryTable td:first-child {
    width: 30px !important;
    min-width: 30px !important;
    max-width: 30px !important;
}
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Quiz Category</h6>
                    </div>
                </div>
                
                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_quiz cursor-pointer"></i>&nbsp;&nbsp;
                        <i class="fas fa-plus create_new_quiz_modal_button cursor-pointer"></i>

                        <!-- Bulk Delete Bar -->
                        <div id="category_bulk_delete_bar">
                            <span id="category_bulk_selected_count">0 selected</span>
                            <button id="category_bulk_delete_btn"><i class="fas fa-trash me-1"></i> Delete Selected</button>
                        </div>

                        <table class="table quizCategoryTable align-items-center mb-0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2" style="width:30px;">
                                        <input type="checkbox" id="select_all_categories" title="Select All">
                                    </th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Category</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Description</th>
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

<div class="modal fade" id="createQuizCategoryModal" tabindex="-1" aria-labelledby="createQuizCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createQuizCategoryModalLabel">Add Quiz Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="add_quiz_category_form" enctype="multipart/form-data"> 
                    @csrf 
                    <input type="hidden" class="quiz_category_id" name="quiz_category_id" id="quiz_category_id" value="">
                    <div class="row">
                        <div class="col-md-12 mb-2">
							<div class="input-group input-group-outline">
								<label class="form-label">Name</label>
								<input type="text" class="form-control category_title" name="category_title" id="category_title" onfocus="focused(this)" onfocusout="defocused(this)">
							</div>
							<small class="text-danger error-text category_title_error"></small>
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
                <button type="button" class="btn btn-primary create_new_quiz_category">Save Category</button>
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

        // ── FIX: shared DataTable config ──
        var dtConfig = {
            responsive: true,
            autoWidth: false,
            columnDefs: [
                { width: '30px', targets: 0 }
            ],
            columns: [
                { orderable: false, searchable: false },
                { orderable: true },
                { orderable: true },
                { orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[1, 'asc']]
        };

        var categoryTable = $('.quizCategoryTable').DataTable(dtConfig);

        $('.create_new_quiz_modal_button').on('click', function() {
            resetForm(); 
            $('.quiz_category_id').val('');
            $('#createQuizCategoryModalLabel').text('Add Quiz Category');
            $('.create_new_quiz_category').text('Save Category');
            new bootstrap.Modal(document.getElementById('createQuizCategoryModal')).show();
        });
        
        $(document).on('click', '.edit_category', function() {
            $('.quiz_category_id').val($(this).data('id'));
            $('.category_title').val($(this).data('name'));
            $('.description').val($(this).data('description'));
            
            $('.add_quiz_category_form').find('input, textarea, select').each(function () {
                if($(this).val()) {
                    focused(this);
                }
            });
            
            $('#createQuizCategoryModalLabel').text('Update Category');
            $('.create_new_quiz_category').text('Update Category');
            new bootstrap.Modal(document.getElementById('createQuizCategoryModal')).show();
        }); 
        
        $(document).on('click', '.create_new_quiz_category', function () {
            showLoader();

            let form = document.querySelector('.add_quiz_category_form');
            let formData = new FormData(form);

            $('.error-text').text('');
            let isUpdate = $('#quiz_category_id').val() != '';

            $.ajax({
                url: "{{ route('add.category.ajax') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.create_new_quiz_category').text(isUpdate ? 'Updating...' : 'Saving...').prop('disabled', true);
                },
                success: function (response) {
                    hideLoader();
                    if (response.status) {
                        showToaster('success', response.message);
                        resetForm();
                        bootstrap.Modal.getInstance(document.getElementById('createQuizCategoryModal')).hide();
                        quizCategoryData(); 
                    } else {
                        showToaster('error', response.message);
                    }
                },
                error: function (xhr) {
                    hideLoader();
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('[name="' + key + '"]').closest('.mb-2').find('.error-text').text(value[0]);
                        });
                    } else {
                        showToaster('error', 'Something went wrong!');
                    }
                },
                complete: function () {
                    $('.create_new_quiz_category').text(isUpdate ? 'Update Category' : 'Save Category').prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.refresh_quiz', function () {
            quizCategoryData();
        });
        
        quizCategoryData();
        
        function quizCategoryData() {
            showLoader();

            $.get("{{ route('quiz.category.data') }}").done(function (response) {
                let rows = [];

                if (response.status && response.data.length > 0) {
                    response.data.forEach(category => {
                        let totalQuizzes = category.quizzes ? category.quizzes.length : 0;
                        
                        var delete_button = `<i class="fas fa-trash text-danger cursor-pointer delete_category" data-id="${category.id}"></i>`;
                        if(totalQuizzes != 0){
                            delete_button = '';
                        }
                        
                        rows.push([
                            // Column 0 - Checkbox
                            `<input type="checkbox" class="category-checkbox" value="${category.id}" ${totalQuizzes != 0 ? 'disabled title="Cannot delete: has quizzes"' : ''}>`,

                            // Column 1 - Category Name
                            `<div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0 text-sm">${category.name ?? ''}</h6>
                                    <p class="text-xs text-secondary mb-0">Quiz Available: ${totalQuizzes}</p>
                                </div>
                            </div>`,

                            // Column 2 - Description
                            `<p class="text-sm">${category.description ?? ''}</p>`,

                            // Column 3 - Actions
                            `<i class="fas fa-edit text-info cursor-pointer edit_category me-2" 
                                data-id="${category.id}" 
                                data-name="${category.name}" 
                                data-description="${category.description ?? ''}"></i>
                             ${delete_button}`
                        ]);
                    });
                }

                categoryTable.destroy();
                $('.quizCategoryTable tbody').html('');

                categoryTable = $('.quizCategoryTable').DataTable({
                    ...dtConfig,
                    data: rows,
                    language: {
                        emptyTable: 'No Categories Found'
                    }
                });

                // Reset checkboxes & bulk bar after reload
                $('#select_all_categories').prop('checked', false);
                updateCategoryBulkBar();

                hideLoader();
            }).fail(function (err) {
                hideLoader();
                console.error('Category fetch error', err);
            });
        }

        // ========================== CHECKBOX / BULK DELETE LOGIC ==========================

        // Select All — only non-disabled checkboxes
        $(document).on('change', '#select_all_categories', function () {
            var checked = $(this).is(':checked');
            $('.quizCategoryTable tbody input.category-checkbox:not(:disabled)').prop('checked', checked);
            updateCategoryBulkBar();
        });

        // Individual checkbox change
        $(document).on('change', '.category-checkbox', function () {
            var total   = $('.quizCategoryTable tbody input.category-checkbox:not(:disabled)').length;
            var checked = $('.quizCategoryTable tbody input.category-checkbox:not(:disabled):checked').length;
            $('#select_all_categories').prop('checked', total > 0 && total === checked);
            updateCategoryBulkBar();
        });

        function updateCategoryBulkBar() {
            var count = $('.quizCategoryTable tbody input.category-checkbox:checked').length;
            if (count > 0) {
                $('#category_bulk_selected_count').text(count + ' selected');
                $('#category_bulk_delete_bar').css('display', 'flex');
            } else {
                $('#category_bulk_delete_bar').css('display', 'none');
            }
        }

        // Bulk Delete button
        $(document).on('click', '#category_bulk_delete_btn', function () {
            var ids = [];
            $('.quizCategoryTable tbody input.category-checkbox:checked').each(function () {
                ids.push($(this).val());
            });
            if (!ids.length) return;

            Swal.fire({
                title: 'Delete ' + ids.length + ' categor' + (ids.length > 1 ? 'ies' : 'y') + '?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete!'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                showLoader();
                var token  = "{{ csrf_token() }}";
                var done   = 0;
                var failed = 0;

                function deleteNext(index) {
                    if (index >= ids.length) {
                        hideLoader();
                        quizCategoryData();
                        var msg = done + ' categor' + (done !== 1 ? 'ies' : 'y') + ' deleted successfully!';
                        if (failed > 0) msg += ' ' + failed + ' failed.';
                        showToaster('success', msg);
                        return;
                    }
                    $.ajax({
                        url: "{{ route('category.delete') }}",
                        type: 'POST',
                        data: { id: ids[index], _token: token },
                        success : function (res) { if (res.status) done++; else failed++; },
                        error   : function ()    { failed++; },
                        complete: function ()    { deleteNext(index + 1); }
                    });
                }

                deleteNext(0);
            });
        });

        // ========================== SINGLE DELETE ==========================

        $(document).on('click', '.delete_category', function () {
            var id = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure delete this category?',
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
                        url: "{{ route('category.delete') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            if (response.status) {
                                showToaster('success', response.message);
                                quizCategoryData(); 
                            } else {
                                showToaster('error', response.message);
                            }
                        },
                        error: function () {
                            hideLoader();
                            Swal.fire('Error!', 'Something went wrong during deletion.', 'error');
                        }
                    });
                }
            });
        });
            
        function resetForm() {
            $('.add_quiz_category_form')[0].reset();
            $('#quiz_id').val('');
            $('.error-text').text('');
            
            $('.add_quiz_category_form').find('input, textarea, select').each(function () {
                defocused(this);
            });
        }
        
    });
})(jQuery);
</script>
@endsection