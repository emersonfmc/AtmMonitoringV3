@extends('layouts.master')

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') ATM / Passbook / Simcard @endslot
        @slot('title') Clients @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <div class="row align-items-end">
                        <form action="{{ route('pension.number.validate') }}" method="POST" id="validatePensionNumber" class="d-flex">
                            @csrf
                            <div class="form-group col-md-4">
                                <label class="fw-bold h6">Validate SSS / GSIS : <span class="fs-6 text-danger">( Ex. SSS 00-0000000-0 / GSIS 00-0000000-00 )</span></label>
                                <input type="text" name="pension_number" id="pension_number" class="pension_number_mask form-control" placeholder="Enter SSS Number" required>
                            </div>
                            <div class="col-md-2 ms-3 mt-4">
                                <button type="submit" class="btn btn-primary">Validate</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-8 text-start">
                            <h4 class="card-title">Clients</h4>
                            <p class="card-title-desc">
                                Clients' financial assets are carefully monitored, including their ATM transactions, Passbook updates,
                                and SIM card management to ensure seamless and secure banking operations.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-success me-2">
                                <i class="fas fa-download me-1"></i> Generate Reports
                            </button>
                            <span id="AddClientButton" style="display: none;">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAreaModal"><i
                                    class="fas fa-plus-circle me-1"></i> Create Area
                                </button>
                            </span>
                        </div>
                    </div>
                    <hr>


                    <div class="table-responsive">
                        <table id="FetchingDatatable" class="table table-border dt-responsive wrap table-design" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl</th>
                                    <th>Area No.</th>
                                    <th>Area Name</th>
                                    <th>District</th>
                                    {{-- <th>Email</th> --}}
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
    </div>

    <div class="modal fade" id="createClientModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="createClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-uppercase">Create Client</h5>
                    <button type="button" class="btn-close closeCreateModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closeCreateModal" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.pension_number_mask').inputmask('99-9999999-9', {
                placeholder: "",  // Placeholder for the input
                removeMaskOnSubmit: true  // Removes the mask when submitting the form
            });

            $('#validatePensionNumber').validate({
                rules: {
                    pension_number: { required: true },  // Rule for pension_number field
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
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.success,
                                    icon: 'success',
                                }).then((result) => {
                                    // Check if the user clicked "OK"
                                    if (result.isConfirmed) {
                                        // Display the "Create Client" button
                                        $('#AddClientButton').show();

                                        // Open the create client modal
                                        $('#createClientModal').modal('show');
                                    }
                                });
                            }
                            else if (response.error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.error,
                                    icon: 'error',
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = 'An error occurred. Please try again later.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        });
    </script>


@endsection
