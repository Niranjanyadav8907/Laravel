@extends('layouts.admin')

@section('title', 'Profile') 
@section('page-title', 'Profile')
@section('breadcrumb', 'Profile') 

@section('content') 

<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
    </div>
    
    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="{{ auth()->user()->image ? asset('assets/images/profile_images/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200&background=random' }}" 
                         alt="profile_image" 
                         class="w-100 border-radius-lg shadow-sm cursor-pointer"
                         id="profileImage"
                         data-toggle="tooltip" 
                         title="Click to update profile image">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    <p class="mb-0 font-weight-normal text-sm">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                        <h6 class="mb-3">Profile Information</h6>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-3">
                <form class="update_profile_form" enctype="multipart/form-data">
                    @csrf
                    <input type="file" 
                           class="d-none" 
                           name="image" 
                           id="profile_image_input" 
                           accept="image/*">
                    <input type="hidden" name="existing_image" id="existing_image" value="{{ auth()->user()->image }}">
                    
                    <div class="row">

                        {{-- Email --}}
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Email address</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control border border-2 p-2" 
                                   value="{{ auth()->user()->email }}" 
                                   readonly 
                                   style="background-color: #f0f0f0; cursor: not-allowed;">
                        </div>

                        {{-- Name --}}
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Name *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="form-control border border-2 p-2" 
                                   value="{{ auth()->user()->name }}" 
                                   placeholder="Enter your full name"
                                   onfocus="focused(this)" 
                                   onfocusout="defocused(this)">
                            <small class="text-danger error-text name_error"></small>
                        </div>

                        {{-- Phone Number --}}
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Phone Number</label>
                            <input type="text" 
                                   name="phone_number" 
                                   id="phone_number"
                                   class="form-control border border-2 p-2" 
                                   value="{{ auth()->user()->phone_number }}" 
                                   placeholder="Enter your phone number"
                                   onfocus="focused(this)" 
                                   onfocusout="defocused(this)">
                            <small class="text-danger error-text phone_number_error"></small>
                        </div>

                        {{-- About --}}
                        <div class="mb-3 col-md-12">
                            <label for="about">About</label>
                            <textarea class="form-control border border-2 p-2" 
                                      placeholder="Write something about yourself"
                                      id="about" 
                                      name="about" 
                                      rows="4" 
                                      cols="50"
                                      onfocus="focused(this)" 
                                      onfocusout="defocused(this)">{{ auth()->user()->about }}</textarea>
                            <small class="text-danger error-text about_error"></small>
                        </div>

                        {{-- Change Password Dropdown --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="button" class="btn btn-outline-danger w-100" id="togglePasswordFields">
                                <i class="fas fa-lock me-2"></i> CHANGE PASSWORD 
                                <i class="fas fa-chevron-down ms-2" id="passwordChevron"></i>
                            </button>
                            
                            <div id="passwordDropdown" 
                                 style="display:none; 
                                        border: 1px solid #dee2e6; 
                                        border-radius: 8px; 
                                        padding: 16px; 
                                        margin-top: 8px; 
                                        background: #fff; 
                                        box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
                                        position: relative; 
                                        z-index: 10;">
                                
                                {{-- Old Password --}}
                                <div class="mb-3">
                                    <label class="form-label">Old Password *</label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="old_password" 
                                               id="old_password"
                                               class="form-control border border-2 p-2" 
                                               placeholder="Enter your current password"
                                               autocomplete="new-password"
                                               value="">
                                        <span class="input-group-text cursor-pointer toggle-password" data-target="#old_password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    <small class="text-danger error-text old_password_error"></small>
                                </div>

                                {{-- New Password --}}
                                <div class="mb-3">
                                    <label class="form-label">New Password *</label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="new_password" 
                                               id="new_password"
                                               class="form-control border border-2 p-2" 
                                               placeholder="Enter new password (min 8 characters)"
                                               autocomplete="new-password"
                                               value="">
                                        <span class="input-group-text cursor-pointer toggle-password" data-target="#new_password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    <small class="text-danger error-text new_password_error"></small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password *</label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="new_password_confirmation" 
                                               id="new_password_confirmation"
                                               class="form-control border border-2 p-2" 
                                               placeholder="Re-enter new password"
                                               autocomplete="new-password"
                                               value="">
                                        <span class="input-group-text cursor-pointer toggle-password" data-target="#new_password_confirmation">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    <small class="text-danger error-text new_password_confirmation_error"></small>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary" id="cancelPasswordBtn">
                                        <i class="fas fa-times me-1"></i> CANCEL
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn bg-gradient-dark update_profile_btn">
                        UPDATE PROFILE
                    </button>
                    
                    @if(auth()->user()->image)
                        <button type="button" class="btn btn-outline-danger remove_profile_image_btn">
                            REMOVE IMAGE
                        </button>
                    @endif

                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.content_header').hide();

    // ========== Profile Image Click ==========
    $('#profileImage').click(function() {
        $('#profile_image_input').click();
    });

    $('#profile_image_input').on('change', function(e) {
        const file = this.files[0];
        const $profileImage = $('#profileImage');
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                $profileImage.attr('src', ev.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            const defaultImg = "{{ auth()->user()->image ? asset('assets/images/profile_images/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200&background=random' }}";
            $profileImage.attr('src', defaultImg);
        }
    });

    // ========== Toggle Password Dropdown ==========
    $('#togglePasswordFields').on('click', function() {
        const $dropdown = $('#passwordDropdown');
        const $chevron  = $('#passwordChevron');
        if ($dropdown.is(':visible')) {
            $dropdown.slideUp(300);
            $chevron.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        } else {
            $dropdown.slideDown(300);
            $chevron.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            setTimeout(function() { $('#old_password').focus(); }, 350);
        }
    });

    // ========== Cancel Password ==========
    $('#cancelPasswordBtn').on('click', function() {
        $('#passwordDropdown').slideUp(300);
        $('#passwordChevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        $('#old_password, #new_password, #new_password_confirmation').val('');
        $('.error-text').text('');
        $('#passwordDropdown input').attr('type', 'password');
        $('#passwordDropdown .toggle-password i').removeClass('fa-eye-slash').addClass('fa-eye');
    });

    // ========== Toggle Password Visibility ==========
    $(document).on('click', '.toggle-password', function() {
        const target = $(this).data('target');
        const $input = $(target);
        const $icon  = $(this).find('i');
        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // ========== UPDATE PROFILE Button ==========
    $('.update_profile_btn').on('click', function() {
        showLoader();
        $('.error-text').text('');

        let form     = document.querySelector('.update_profile_form');
        let formData = new FormData(form);

        $.ajax({
            url: "{{ route('profile.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.update_profile_btn').text('Please wait...').prop('disabled', true);
            },
            success: function(response) {
                hideLoader();
                if (response.status) {
                    showToaster('success', response.message);

                    if (response.data && response.data.image) {
                        const newImageUrl = "{{ asset('assets/images/profile_images/') }}/" + response.data.image;
                        $('#profileImage').attr('src', newImageUrl);
                    }
                    if (response.data && response.data.name) {
                        $('.h-100 h5').first().text(response.data.name);
                    }
                    if (response.data && response.data.image && $('.remove_profile_image_btn').length === 0) {
                        $('.update_profile_btn').after(`
                            <button type="button" class="btn btn-outline-danger remove_profile_image_btn">
                                REMOVE IMAGE
                            </button>
                        `);
                    }

                    $('#passwordDropdown').slideUp(300);
                    $('#passwordChevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    $('#old_password, #new_password, #new_password_confirmation').val('');
                    $('#passwordDropdown input').attr('type', 'password');
                    $('#passwordDropdown .toggle-password i').removeClass('fa-eye-slash').addClass('fa-eye');
                    $('#profile_image_input').val('');

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
                    if (errors.old_password || errors.new_password) {
                        $('#passwordDropdown').slideDown(300);
                        $('#passwordChevron').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                    }
                } else {
                    showToaster('error', 'Something went wrong!');
                }
            },
            complete: function() {
                $('.update_profile_btn').text('UPDATE PROFILE').prop('disabled', false);
            }
        });
    });

    // ========== Remove Profile Image ==========
    $(document).on('click', '.remove_profile_image_btn', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to remove your profile image!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();
                $.ajax({
                    url: "{{ route('profile.remove-image') }}",
                    type: "POST",
                    data: {
                        _token : "{{ csrf_token() }}",
                        _method: "DELETE"
                    },
                    success: function(response) {
                        hideLoader();
                        if (response.status) {
                            showToaster('success', response.message);
                            const defaultImg = "https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=random";
                            $('#profileImage').attr('src', defaultImg);
                            $('.remove_profile_image_btn').remove();
                            $('#profile_image_input').val('');
                            $('#existing_image').val('');
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

});
</script>

@endsection