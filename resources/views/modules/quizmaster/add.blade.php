@extends('layouts.admin')

@section('title', 'Quiz Master')
@section('page-title', 'Quiz Master Management')
@section('breadcrumb', 'Quiz Master') 

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Quiz Master List</h6>
                    </div>
                </div>
                
                <div class="card-body px-0 pb-2 m-4">
                    <div class="table-responsive">
                        <i class="fas fa-sync refresh_quizmaster cursor-pointer"></i>&nbsp;&nbsp;
                        <i class="fas fa-plus create_new_quizmaster_modal_button cursor-pointer"></i>
                        <table class="table quizmasterTable align-items-center mb-0">
                            <thead>
                                <tr>    
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Quiz Master Name</th>
                                    <th class="text-uppercase text-dark text-xxl font-weight-bolder opacity-7 ps-2">Role</th>
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

<!-- Add/Edit Modal -->
{{-- id kept on modal itself because Bootstrap requires it for .modal('show') targeting --}}
<div class="modal fade" id="createQuizmasterModal" tabindex="-1" aria-labelledby="createQuizmasterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- id kept here because aria-labelledby references it --}}
                <h5 class="modal-title" id="createQuizmasterModalLabel">Add New Quiz Master</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="add_quizmaster_form" enctype="multipart/form-data"> 
                    @csrf 
                    {{-- name="quizmaster_id" must stay for FormData POST, id replaced with class --}}
                    <input type="hidden" name="quizmaster_id" class="quizmaster_id_input">
                    
                    <div class="row">

                        {{-- Name --}}
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control qm_name" name="name"
                                    onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text name_error"></small>
                        </div>
                        
                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control qm_email" name="email"
                                    onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <small class="text-danger error-text email_error"></small>
                        </div>
                        
                        {{-- Role Dropdown --}}
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Role</label>
                                <select class="form-control qm_role" name="role"
                                    onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Role</option>
                                    <option value="Vice President">Vice President</option>
                                    <option value="Quiz Master">Quiz Master</option>
                                </select>
                            </div>
                            <small class="text-danger error-text role_error"></small>
                        </div>
                        
                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled">
                                <label class="form-label">Status</label>
                                <select class="form-control qm_status" name="status"
                                    onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value="">Select Status</option>
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <small class="text-danger error-text status_error"></small>
                        </div>
                        
                        {{-- Bio --}}
                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Bio</label>
                                <textarea class="form-control qm_bio" name="bio" rows="4"
                                    onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                            </div>
                            <small class="text-danger error-text bio_error"></small>
                        </div>
                        
                        {{-- Photo Upload --}}
                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-outline is-focused is-filled" style="display:none;">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control qm_photo_input" name="photo" accept="image/*">
                            </div>
                            <img data-toggle="tooltip" title="Click To Update Photo!" 
                                src="" 
                                style="width:150px; height:150px; display:none; object-fit:cover;" 
                                class="img-thumbnail photo_preview cursor-pointer rounded-circle">
                            <small class="text-danger error-text photo_error"></small>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save_quizmaster">Save Quiz Master</button>
            </div>
        </div>
    </div>
</div>

<script>
    // ========== Photo Preview Click Handler ==========
    $('.photo_preview').click(function() {
        $('.qm_photo_input').click();
    });

    // ========== Photo Change Handler ==========
    $('.qm_photo_input').on('change', function() {
        const file    = this.files[0];
        const $preview = $('.photo_preview');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                $preview.attr('src', ev.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            $preview.attr('src', '').hide();
        }
    });

    $(document).ready(function() {
        $('.content_header').hide();
    
        // ========== Add New Quiz Master Button Click ==========
        $('.create_new_quizmaster_modal_button').on('click', function() {
            resetForm(); 
            var img_url = "{{ asset('assets/images/quizmaster/default_avatar.png') }}";
            $('.photo_preview').attr('src', img_url).show();
            $('#createQuizmasterModalLabel').text('Add New Quiz Master');
            $('.save_quizmaster').text('Save Quiz Master');
            $('#createQuizmasterModal').modal('show');
        });
        
        // ========== Edit Quiz Master Button Click ==========
        $(document).on('click', '.edit_quizmaster', function() {
            var id     = $(this).data('id');
            var name   = $(this).data('name');
            var email  = $(this).data('email');
            var role   = $(this).data('role');
            var bio    = $(this).data('bio');
            var status = $(this).data('status');
            var photo  = $(this).data('photo');
            
            $('.error-text').text('');

            // ---- class used everywhere instead of id ----
            $('.quizmaster_id_input').val(id);
            $('.qm_name').val(name);
            $('.qm_email').val(email);
            $('.qm_role').val(role);
            $('.qm_bio').val(bio);
            $('.qm_status').val(status);
            
            if (photo) {
                var img_url = "{{ asset('assets/images/quizmaster/') }}" + "/" + photo;
                $('.photo_preview').attr('src', img_url).show();
            } else {
                var img_url = "{{ asset('assets/images/quizmaster/default_avatar.png') }}";
                $('.photo_preview').attr('src', img_url).show();
            }
                       
            $('.add_quizmaster_form').find('input, textarea, select').each(function () {
                if ($(this).val()) {
                    focused(this);
                }
            });
            
            $('#createQuizmasterModalLabel').text('Update Quiz Master');
            $('.save_quizmaster').text('Update Quiz Master');
            $('#createQuizmasterModal').modal('show');
        });
        
        // ========== Save / Update Quiz Master ==========
        $(document).on('click', '.save_quizmaster', function () {
            showLoader();

            let form     = document.querySelector('.add_quizmaster_form');
            let formData = new FormData(form);

            $('.error-text').text('');

            $.ajax({
                url: "{{ route('quizmaster.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.save_quizmaster').text('Please wait...').prop('disabled', true);
                },
                success: function (response) {
                    hideLoader();
                    if (response.status) {
                        showToaster('success', response.message);
                        resetForm();
                        $('#createQuizmasterModal').modal('hide');
                        loadQuizmasterData();
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
                    // check hidden input by class
                    $('.save_quizmaster')
                        .text($('.quizmaster_id_input').val() ? 'Update Quiz Master' : 'Save Quiz Master')
                        .prop('disabled', false);
                }
            });
        });

        // ========== Refresh Button ==========
        $(document).on('click', '.refresh_quizmaster', function () {
            loadQuizmasterData();
        });
        
        // ========== Delete Quiz Master ==========
        $(document).on('click', '.delete_quizmaster', function () {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure you want to delete this Quiz Master?',
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
                        url: "{{ route('quizmaster.delete') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            showToaster('success', response.message);
                            loadQuizmasterData(); 
                        },
                        error: function () {
                            hideLoader();
                            Swal.fire('Error!', 'Something went wrong during deletion.', 'error');
                        }
                    });
                }
            });
        });
        
        // ========== Update Status (inline table dropdown) ==========
        $(document).on('change', '.update_status', function () {
            let status = $(this).val();
            let id     = $(this).data('id');
            let $this  = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the status!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();
                    $.ajax({
                        url: "{{ route('quizmaster.update.status') }}", 
                        type: "POST",
                        data: {
                            id: id,
                            status: status,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            hideLoader();
                            if (response.status) {
                                showToaster('success', response.message);
                                loadQuizmasterData();
                            } else {
                                showToaster('error', response.message);
                                $this.val($this.data('prev'));
                            }
                        },
                        error: function () {
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

        $(document).on('focus', '.update_status', function () {
            $(this).data('prev', $(this).val());
        });
        
        // ========== Load Quiz Master Data ==========
        loadQuizmasterData();
        
        function loadQuizmasterData() {
            showLoader();

            $.get("{{ route('quizmaster.data') }}").done(function (response) {
                let rows = '';
                
                response.forEach(quizmaster => {
                    const bio = quizmaster.bio ? quizmaster.bio.substring(0, 50) + '...' : '-';
                    
                    var img_url = "{{ asset('assets/images/quizmaster/default_avatar.png') }}";
                    if (quizmaster.photo) {
                        img_url = "{{ asset('assets/images/quizmaster') }}" + "/" + quizmaster.photo;
                    }
                    
                    rows += `
                    <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="${img_url}" class="me-3 rounded-circle" width="60" height="60" 
                                style="object-fit:cover;" alt="Photo">
                            <div>
                              <h6 class="mb-0 text-sm">${quizmaster.name}</h6>
                              <p class="text-xs text-secondary mb-0">${quizmaster.email}</p>
                              <p class="text-xs text-muted mb-0">${bio}</p>
                            </div>
                          </div>
                        </td>
                        <td><p class="text-sm font-weight-bold mb-0">${quizmaster.role}</p></td>
                        <td>
                            <div class="input-group input-group-outline is-filled">
                                ${statusUI(quizmaster.status, quizmaster.id)}
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-edit text-info cursor-pointer edit_quizmaster me-2"
                               data-id="${quizmaster.id}"
                               data-name="${quizmaster.name}"
                               data-email="${quizmaster.email}"
                               data-role="${quizmaster.role}"
                               data-bio="${quizmaster.bio ?? ''}"
                               data-status="${quizmaster.status}"
                               data-photo="${quizmaster.photo ?? ''}">
                            </i>
                            <i class="fas fa-trash text-danger cursor-pointer delete_quizmaster" 
                               data-id="${quizmaster.id}">
                            </i>
                        </td>
                    </tr>`;
                });

                $('.quizmasterTable tbody').html(rows);
                hideLoader();
            })
            .fail(function (err) {
                hideLoader();
                console.error('Quiz Master fetch error', err);
            });
        }
        
        function statusUI(status, id) {
            const colors = { Active: 'success', Inactive: 'danger' };
            let options  = ['Active', 'Inactive']
                            .map(s => `<option ${s === status ? 'selected' : ''}>${s}</option>`)
                            .join('');

            return `
                <select class="form-control update_status border-${colors[status]}" 
                    data-id="${id}" 
                    style="border-top: 2px solid var(--bs-${colors[status]});">
                    ${options}
                </select>
            `;
        }

        function resetForm() {
            $('.add_quizmaster_form')[0].reset();
            $('.quizmaster_id_input').val('');
            $('.error-text').text('');
            $('.photo_preview').attr('src', '').hide();
            
            $('.add_quizmaster_form').find('input, textarea, select').each(function () {
                defocused(this);
            });
        }
        
    });
</script>

@endsection