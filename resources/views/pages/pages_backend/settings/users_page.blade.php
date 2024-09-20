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
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDepartment"><i
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






@endsection
@section('script')

@endsection
