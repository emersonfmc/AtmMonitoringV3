@extends('layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Settings @endslot
        @slot('title') Branch @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8 text-start">
                            <h4 class="card-title">Branch</h4>
                            <p class="card-title-desc">
                                This branch provides loans to clients with GSIS and SSS loans.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDepartment"><i
                                class="fas fa-plus-circle me-1"></i> Create Branch</button>
                        </div>
                    </div>
                    <hr>


                    <div class="table-responsive">
                        <table id="FetchingDatatable" class="table table-border dt-responsive wrap table-design" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl</th>
                                    <th>Branch Location</th>
                                    <th>Branch Head</th>
                                    <th>District</th>
                                    <th>Area</th>
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
            const dataTable = new ServerSideDataTable('#FetchingDatatable');
            var url = '{!! route('settings.branch.data') !!}';
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
                    data: null,
                    name: 'branch_location',
                    render: function(data, type, row, meta) {
                        var abbreviation = row.branch_abbreviation ? row.branch_abbreviation : '';
                        var separator = row.branch_abbreviation ? ' - ' : '';
                        return '<span class="fw-bold h6">' + '<span class="fw-bold h6 text-primary">' + abbreviation + '</span>' + separator + row.branch_location + '</span>';
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'branch_head',
                    name: 'branch_head',
                    render: function(data, type, row, meta) {
                        return '<span class="fw-bold h6">' + data + '</span>'; // Display user's name
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'district_id',
                    name: 'district.district_name',
                    render: function(data, type, row, meta) {
                        return row.district ? '<span>' + row.district.district_name + '</span>' : '';
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'area_id',
                    name: 'district.area',
                    render: function(data, type, row, meta) {
                        return row.area ? '<span>' + row.area.area_name + '</span>' : '';
                    },
                    orderable: true,
                    searchable: true,
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
            $('#FetchingDatatable').DataTable({
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
