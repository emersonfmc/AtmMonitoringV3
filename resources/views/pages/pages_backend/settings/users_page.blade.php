@extends('layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Settings @endslot
        @slot('title') Users @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8 text-start">
                            <h4 class="card-title">Users</h4>
                            <p class="card-title-desc">
                                Individuals who interact with a system, accessing its features and
                                functionalities based on their roles and permissions.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal"><i
                                class="fas fa-plus-circle me-1"></i> Create Users</button>
                        </div>
                    </div>
                    <hr>


                    <div class="table-responsive">
                        <table id="usersPageTable" class="table table-border dt-responsive wrap table-design" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Created Date</th>
                                    <th>Roles and Permission</th>
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

    <script>
        $(document).ready(function () {
            const dataTable = new ServerSideDataTable('#usersPageTable');
            var url = '{!! route('users.data') !!}';
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
                        return '<span class="fw-bold h6">' + data + '</span>'; // Display user's ID
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row, meta) {
                        return '<span class="fw-bold h6">' + data + '</span>'; // Display user's name
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data, type, row, meta) {
                        return '<span>' + data + '</span>'; // Display user's email
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'password',
                    name: 'password',
                    render: function(data, type, row, meta) {
                        return '<span>' + 'Encrypted' + '</span>'; // Display user's email
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
                    name: 'roles',
                    render: function(data, type, row, meta) {
                        // Display the roles, or 'N/A' if no roles are assigned
                        // return data ? '<span class="text-primary fw-bold h6">' + data + '</span>' : 'N/A';

                        return '<span>' + 'N / A' + '</span>'; // Display created date
                    },
                    orderable: false,
                    searchable: false,
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
            $('#usersPageTable').DataTable({
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
    </script>

    <div class="modal fade" id="createUserModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-uppercase" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('users.create')  }}" id="createUserValidateForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold h6">User type</label>
                                    <select id="userTypeSelect" name="user_type" class="form-select">
                                        <option value="">Select User Type</option>
                                        <option value="Head_Office">Head Office</option>
                                        <option value="District">District</option>
                                        <option value="Area">Area</option>
                                        <option value="Branch">Branch</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="fw-bold h5 text-primary">Personal Information</label>
                                <hr>

                                <div class="form-group mb-2">
                                    <label class="fw-bold h6">Fullname</label>
                                    <input type="text" name="name" class="form-control" placeholder="Fullname">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="fw-bold h6">Contact No</label>
                                    <input type="text" name="contact_no" class="form-control" placeholder="Contact No.">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="fw-bold h6">Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Address">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="fw-bold h6">Employee No</label>
                                    <input type="text" name="employee_no" class="form-control" placeholder="Employee No.">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold h5 text-primary">User Account Details</label>
                                <hr>

                                <div class="form-group mb-2">
                                    <label class="fw-bold h6">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="fw-bold h6">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password.">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="fw-bold h6">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Address">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="fw-bold h6">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <span id="HeadOfficeDisplay" style="display: none;">
                                    <label class="fw-bold h5 text-primary">Head Office Details</label>
                                    <hr>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">User Group</label>
                                        <select id="user_group_id" name="user_group_id" class="form-select select2">
                                            <option value="" selected disabled>Select User Type</option>
                                            @foreach ($user_groups as $user_group)
                                                <option value="{{ $user_group->id }}">{{ $user_group->group_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </span>

                                <span id="DistrictDisplay" style="display: none;">
                                    <label class="fw-bold h5 text-primary">Districts Details</label>
                                    <hr>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">District</label>
                                        <select id="district_id" name="district_id" class="form-select">
                                            <option value="" selected disabled>Select District</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">District Session</label>
                                        <select id="district_session_id" name="district_session_id" class="form-select">
                                            <option value="" selected disabled>Select District Session</option>
                                        </select>
                                    </div>
                                </span>

                                <span id="AreaDisplay" style="display: none;">
                                    <label class="fw-bold h5 text-primary">Area Details</label>
                                    <hr>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">District Manageer</label>
                                        <select id="district_manager_id" name="district_manager_id" class="form-select">
                                            <option value="" selected disabled>Select District Manager</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">Area Supervisor</label>
                                        <select id="area_supervisor_id" name="area_supervisor_id" class="form-select" disabled>
                                            <option value="" selected disabled>Select Area Supervisor</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">District | Area</label>
                                        <select id="district_area_id" name="district_area_id" class="form-select" disabled>
                                            <option value="" selected disabled>District | Area</option>
                                        </select>
                                    </div>

                                </span>

                                <span id="BranchDisplay" style="display: none;">
                                    <label class="fw-bold h5 text-primary">Branch Details</label>
                                    <hr>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">District Manageer</label>
                                        <select id="district_manager_io" name="district_manager_io" class="form-select">
                                            <option value="" selected disabled>Select District Manager</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">Area</label>
                                        <select id="area_id" name="area_id" class="form-select">
                                            <option value="" selected disabled>Select Area</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">Branch</label>
                                        <select id="branch_id" name="branch_id" class="form-select">
                                            <option value="" selected disabled>Select Branch</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="fw-bold h6">User Group</label>
                                        <select id="user_group_branch_id" name="user_group_branch_id" class="form-select">
                                            <option value="" selected disabled>Select User Type</option>
                                            @foreach ($user_groups as $user_group)
                                                <option value="{{ $user_group->id }}">{{ $user_group->group_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </span>
                            </div>
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
    $(document).ready(function(){
        // $('#userTypeSelect').select2({
        //     dropdownParent: $('#createUserModal')
        // });

        $('#user_group_id').select2({
            dropdownParent: $('#createUserModal')
        });

        $('#userTypeSelect').on('change', function() {
            var selectedUserType = $(this).val();

            if(selectedUserType === 'Head_Office')
            {
                $('#HeadOfficeDisplay').show();
                $('#DistrictDisplay').hide();
                $('#AreaDisplay').hide();
                $('#BranchDisplay').hide();
            }
            else if(selectedUserType === 'District')
            {
                $('#HeadOfficeDisplay').hide();
                $('#DistrictDisplay').show();
                $('#AreaDisplay').hide();
                $('#BranchDisplay').hide();
            }
            else if(selectedUserType === 'Area')
            {
                $('#HeadOfficeDisplay').hide();
                $('#DistrictDisplay').hide();
                $('#AreaDisplay').show();
                $('#BranchDisplay').hide();
            }
            else if(selectedUserType === 'Branch')
            {
                $('#HeadOfficeDisplay').hide();
                $('#DistrictDisplay').hide();
                $('#AreaDisplay').hide();
                $('#BranchDisplay').show();
            }
            else
            {
                $('#HeadOfficeDisplay').hide();
                $('#DistrictDisplay').hide();
                $('#AreaDisplay').hide();
                $('#BranchDisplay').hide();
            }
        });
    });
</script>




@endsection
@section('script')

@endsection
