@extends('layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Settings @endslot
        @slot('title') Pension Types @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8 text-start">
                            <h4 class="card-title">Pension Types</h4>
                            <p class="card-title-desc">
                                A list of pension types available for retirees, primarily
                                from the Social Security System (SSS) for private sector
                                employees, and the Government Service Insurance System (GSIS)
                                for government workers
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBanks"><i
                                class="fas fa-plus-circle me-1"></i> Create Pension Types</button>
                        </div>
                    </div>
                    <hr>


                    <div class="table-responsive">
                        <table id="SettingsPensionTypesTable" class="table table-border dt-responsive wrap table-design" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl</th>
                                    <th>Types</th>
                                    <th>Pension Name</th>
                                    <th>Status</th>
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

    <script>
        $(document).ready(function () {
            const dataTable = new ServerSideDataTable('#SettingsPensionTypesTable');
            var url = '{!! route('settings.pension.types.data') !!}';
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
                    data: 'types',
                    name: 'types',
                    render: function(data, type, row, meta) {
                        return '<span class="fw-bold h6 text-primary">' + data + '</span>';
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'pension_name',
                    name: 'pension_name',
                    render: function(data, type, row, meta) {
                        return '<span class="fw-bold h6">' + data + '</span>';
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row, meta) {
                        if (data === 'Active') {
                            return '<span class="badge bg-primary">Active</span>';
                        } else if (data === 'Inactive') {
                            return '<span class="badge bg-danger">Inactive</span>';
                        } else {
                            return '<span>No Status</span>';
                        }
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
            ];

            // Log data sent from server
            $('#SettingsPensionTypesTable').DataTable({
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
