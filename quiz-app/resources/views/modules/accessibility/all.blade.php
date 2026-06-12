@extends('layouts.admin')
@section('title', 'Accessibility')
@section('page-title', 'Accessibility')
@section('breadcrumb', 'Accessibility')
@section('content')

<style>
.form-check-input.access-control {
    width: 20px;    
    height: 20px;
    border: 1px solid #e02a6a;
    border-radius: 4px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    outline: none;
    cursor: pointer;
    position: relative;
}

.form-check-input.access-control:checked {
    background-color: gray;
}

.form-check-input.access-control:checked::after {
    content: '✓';
    color: white;
    font-size: 14px;
    position: absolute;
    top: 0;
    left: 3px;
}

.access-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 6px;
}

.access-text {
    min-width: 70px;  
    font-weight: 500;
}

.access-row .access-control {
    margin: 0;
}

</style>
<div class="m-1 py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">

                <div class="card-header bg-gradient-dark text-white">
                    <h5 class="mb-0 text-white"><i class="fas fa-lock me-2"></i> Accessibility Control 
					<a class="small-box-footer refresh_role_list text-danger" style="cursor:pointer;">Refresh List <i class="fas fa-arrow-circle-right"></i></a></h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-start roleAccessablityTable">
                            <thead class="table-light"></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).on('click', '.refresh_role_list', function () {
		getRoleForAccessablitySave();
	});
	
	getRoleForAccessablitySave();

	function getRoleForAccessablitySave() {
		showLoader();
		var id = '';
		$.ajax({
			url: "{{ route('get.role.for.assessablity.save') }}",
			type: "POST",
			data: {
				id: id,
				_token: "{{ csrf_token() }}"
			},
			success: function (response) {
				hideLoader();
				
				if(response.status){
					const modules = ['Dashboard','User', 'Quiz', 'Question', 'QMonitoring', 'TopScorers', 'Achievement', 'Plans', 'Payment', 'Accessibility', 'QuizMaster', 'QuizCategory', 'QuizSchedule','UserQuizReport' ]; 
					const permissions = ['View', 'Add', 'Update', 'Delete'];

					generateTableHeader(response.roles);
					populateAccessTable(response.roles, modules, permissions, response.accessibilities);
				} else {
					Swal.fire('Error!', response.message || 'No roles found.', 'error');
				}
					
			},
			error: function (xhr) {
				hideLoader();
				console.error(xhr.responseText);
				Swal.fire(
					'Error!',
					'Something went wrong while fetching roles.',
					'error'
				);
			}
		});
	}

	function populateAccessTable(roles, modules, permissions, accessibilities) {
    const tbody = $('.roleAccessablityTable tbody');
    tbody.empty();

    modules.forEach(module => {
        let row = `<tr>
            <td class="text-start fw-bold">
                <i class="nav-icon fas fa-dot-circle me-2"></i> ${module}
            </td>`;

        roles.forEach(role => {
            let td = '<td>';

            let permsToShow = permissions;

            if (module === 'Dashboard') {
                permsToShow = ['View'];
            }

            permsToShow.forEach(permission => {
                // Check if permission exists in saved data
                let checked = '';
                let disabled = role.role_name.toLowerCase().includes('admin') ? 'disabled' : '';  

                const access = accessibilities.find(a =>
                    a.role_id == role.id &&
                    a.module === module &&
                    a.action === permission
                );

                if (access && access.access == 1) {
                    checked = 'checked';
                }

                td += `
                <div class="access-row">
                    <span class="access-text">${permission}</span>
                    <input type="checkbox" class="form-check-input access-control" 
                        data-module="${module}" 
                        data-action="${permission}" 
                        data-role="${role.role_name}"
                        ${checked} ${disabled}>
                </div>`;
            });

            td += '</td>';
            row += td;
        });

        row += '</tr>';
        tbody.append(row);
    });

    tbody.append(`
        <tr>
            <td></td>
            ${roles.map((r, i) => i === roles.length - 1 ? 
                `<td>
                    <div class="text-end">
                        <button class="btn btn-success saveChanges">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </td>` : `<td></td>`).join('')}
        </tr>
    `);
}



	function generateTableHeader(roles) {
		const thead = $('.roleAccessablityTable thead');
		thead.empty(); 

		let headerRow = '<tr>';
		headerRow += '<th class="text-start">Module</th>'; 

		roles.forEach(role => {
			headerRow += `<th>${role.role_name}</th>`;
		});

		headerRow += '</tr>';
		thead.append(headerRow);
	}


	
	$(document).on('click', '.saveChanges', function(){
		let accessData = [];

		$('.access-control').each(function() {
			accessData.push({
				module: $(this).data('module'),
				role: $(this).data('role'),
				action: $(this).data('action') || 'Main',
				access: $(this).is(':checked') ? 1 : 0
			});
		});

		showLoader();
		$.ajax({
			url: "{{ route('save.accessibility') }}",
			type: "POST",
			data: {
				_token: "{{ csrf_token() }}",
				accessData: accessData
			},
			success: function(response){
				hideLoader();
				if(response.status){
					Swal.fire('Success!', response.message, 'success');
				} else {
					Swal.fire('Error!', response.message || 'Something went wrong!', 'error');
				}
			},
			error: function(xhr){
				hideLoader();
				Swal.fire('Error!', 'Server error occurred.', 'error');
				console.error(xhr.responseText);
			}
		});
	});

</script>


@endsection