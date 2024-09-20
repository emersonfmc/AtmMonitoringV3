@extends('layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Pages @endslot
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
                        <table id="datatable" class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Created Date</th>
                                    <th>Roles and Permission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td><a href="#" class="badge bg-danger">Encrypted</a></td>
                                    <td> {{ date('F j, Y', strtotime($item->created_at)) }}</td>
                                    <td><a href="#" class="text-primary fw-bold h6">View</a></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="me-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class='bx bxs-pencil text-warning fs-5'></i>
                                            </a>

                                            <a href="#" class="text-danger me-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                <i class='bx bxs-trash fs-5'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
@section('script')

@endsection
