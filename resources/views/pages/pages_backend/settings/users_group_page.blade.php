@extends('layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Settings @endslot
        @slot('title') User Group @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8 text-start">
                            <h4 class="card-title">User Group</h4>
                            <p class="card-title-desc">
                                A classification of users based on shared characteristics or roles,
                                often used to assign specific permissions or access levels within a system.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserGroupModal"><i
                                class="fas fa-plus-circle me-1"></i> Create User Group</button>
                        </div>
                    </div>
                    <hr>


                    <div class="table-responsive">
                        <table id="usersGroupPageTable" class="table table-border dt-responsive wrap table-design" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="modal fade" id="createUserGroupModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-uppercase" id="createUserModalLabel">Create User Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('settings.users.group.create')  }}" id="createValidateForm">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="fw-bold h6">User Group</label>
                            <input type="text" name="user_group" class="form-control" placeholder="Enter User Group" minlength="0" maxlength="50" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const dataTable = new ServerSideDataTable('#usersGroupPageTable');
            var url = '{!! route('settings.users.group.data') !!}';
            const buttons = [{
                text: 'Delete',
                action: function(e, dt, node, config) {
                    // Add your custom button action here
                    alert('Custom button clicked!');
                }
            }];
            const columns = [
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return '<span">' + data + '</span>'; // Display user's ID
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'group_name',
                    name: 'group_name',
                    render: function(data, type, row, meta) {
                        return '<span class="fw-bold h6">' + data + '</span>'; // Display user's name
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'company_id',
                    name: 'company.company_name',
                    render: function(data, type, row, meta) {
                        return row.company ? '<span>' + row.company.company_name + '</span>' : ''; // Check if company exists
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return new Date(data).toLocaleDateString('en-US', {
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric'
                        });
                    }

                },
                {
                    data: null,
                    name: 'action',
                    render: function(data, type, row) {
                        return '<a href="#" class="text-danger deleteUserBtn me-2" data-id="' + row.id +'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><i class="fas fa-trash-alt me-2"></i></a>' +
                               '<a href="#" class="text-warning editUserBtn me-2" data-id="' + row.id +'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User"><i class="fas fa-pencil-alt me-2"></i></a>';
                    },
                    orderable: false,
                    searchable: false,
                }
                // <a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="test">Test</a>

            ];

            // Log data sent from server
            $('#usersGroupPageTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    type: 'GET',
                    dataSrc: function (json) {
                        console.log('Data returned from the server:', json); // Logs entire response
                        return json.data; // Return the actual data array to DataTables
                    }
                },
                columns: columns,
                buttons: buttons
            });
        });

        $(document).ready(function () {
            $('#createValidateForm').validate({
                rules: {
                    user_group: {
                        required: true,
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You want to submit the form',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user clicks "Submit", send the form data via AJAX
                            $.ajax({
                                url: form.action, // Use the form's action attribute
                                type: 'POST',
                                data: $(form).serialize(), // Serialize the form data
                                success: function(response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: response.status,
                                            text: response.message,
                                            showConfirmButton: false
                                        });
                                        // Optionally, reset the form after success
                                        form.reset();
                                        $('#createUserGroupModal').modal('hide'); // Replace with your modal ID
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Something went wrong! Please try again.',
                                        });
                                        $('#createUserGroupModal').modal('hide'); // Replace with your modal ID
                                    }
                                },
                                error: function(xhr) {
                                    // Handle error, display a SweetAlert with error info
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'There was a problem submitting the form. Please try again.',
                                    });
                                }
                            });
                        }
                    });
                }
            });
        });

    </script>






@endsection
@section('script')

@endsection
