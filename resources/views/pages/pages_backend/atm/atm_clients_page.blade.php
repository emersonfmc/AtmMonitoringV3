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

                    <form action="{{ route('pension.number.validate') }}" method="POST" id="validatePensionNumber" class="d-flex">
                        @csrf
                        <div class="form-group">
                            <label class="fw-bold h6">Validate SSS / GSIS : <span class="fs-6 text-danger">( Ex. SSS 00-0000000-0 / GSIS 00-0000000-00 )</span></label>
                            <input type="text" name="pension_number" id="pension_number"
                                    class="pension_number_mask form-control" placeholder="Enter SSS Number"
                                    required>
                        </div>
                        <div class="col-md-2 ms-3 mt-4">
                            <button type="submit" class="btn btn-primary">Validate</button>
                        </div>
                    </form>
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
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal"><i
                                    class="fas fa-plus-circle me-1"></i> Create Client
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
                                    <th>Action</th>
                                    <th>Reference No.</th>
                                    <th>Branch</th>
                                    <th>Clients</th>
                                    <th>Pension No. / Type</th>
                                    <th>ATM / Passbook / Simcard & Bank</th>
                                    <th>PIN Code</th>
                                    <th>Type & Status</th>
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
                    <form action="#" id="createClientValidateForm">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Pension Number</label>
                                    <input type="text" name="pension_number" id="pension_number_get" class="form-control" placeholder="Enter Pension Number"  readonly required>
                                </div>
                            </div>

                            @if(in_array($userGroup, ['Developer', 'Admin', 'Everfirst Admin']))
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="fw-bold h6">Branch</label>
                                        <select name="branch_id" id="branch_id" class="form-select select2">
                                            <option value="" selected disabled>Select Branch</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->branch_abbreviation .' - '. $branch->branch_location }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Pension Number Type</label>
                                    <select name="pension_number_type" id="pension_number_type" class="form-select">
                                        <option value="" selected disabled>Pension Number Type</option>
                                        <option value="SSS">SSS</option>
                                        <option value="GSIS">GSIS</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Pension Type</label>
                                    <select name="pension_type" id="pension_type" class="form-select select2" disabled>
                                        <option value="" selected disabled>Pension Type</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Collection Date</label>
                                    <select name="collection_date" id="collection_date" class="form-select">
                                        <option value="" selected disabled>Collection Date</option>
                                        @foreach ($DataCollectionDates as $DataCollectionDate)
                                            <option value="{{ $DataCollectionDate->id }}">{{ $DataCollectionDate->collection_date }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Firstname</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter Firstname" minlength="0" maxlength="50">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Middlename</label>
                                    <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Enter Middlename" minlength="0" maxlength="50">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Lastname</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Lastname" minlength="0" maxlength="50">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Suffix</label>
                                    <select name="suffix" id="suffix" class="form-select">
                                        <option value="" selected disabled>Suffix</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="Ma.">Ma.</option>
                                        <option value="I.">I.</option>
                                        <option value="II.">II.</option>
                                        <option value="III.">III.</option>
                                        <option value="IV.">IV.</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold h6">Birthdate</label>
                                    <input type="date" name="birth_date" id="birth_date" class="form-control" placeholder="Enter Birthdate">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="text-start">
                            <a href="#" class="btn btn-primary" id="addMoreAtmBtn">Add More</a>
                        </div>

                        <div class="atm-details-wrapper">
                            <div id="AddMoreAtmContainer" class="mb-3">
                                <div class="row atm-details mt-2">
                                    <hr>
                                    <label class="fw-bold h6 text-center mb-3 text-primary">
                                        Add ATM / Passbook / Simcard No.
                                    </label>

                                    <hr>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2 row align-items-center">
                                        <label class="col-form-label col-sm-4 fw-bold">Type</label>
                                        <div class="col-8">
                                            <select name="atm_type[]" class="form-select" required>
                                            <option value="" selected disabled>Type</option>
                                            <option value="ATM">ATM</option>
                                            <option value="Passbook">Passbook</option>
                                            <option value="Sim Card">Sim Card</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="form-group mb-2 row align-items-center">
                                        <label class="col-form-label col-sm-4 fw-bold">ATM / Passbook / Sim No.</label>
                                        <div class="col-8">
                                            <input type="text" name="atm_number[]" class="atm_card_input_mask form-control" placeholder="ATM / Passbook / Sim No." required>
                                        </div>
                                        </div>
                                        <div class="form-group mb-3 row align-items-center">
                                        <label class="col-form-label col-4 fw-bold">Balance</label>
                                        <div class="col-8">
                                            <input type="text" name="atm_balance[]" class="balanceCurrency form-control" value="0" placeholder="Balance" required>
                                        </div>
                                        </div>
                                        <div class="form-group mb-2 row align-items-center">
                                        <label class="font-size col-form-label col-4 fw-bold">Banks</label>
                                        <div class="col-8">
                                            <div class="form-group">
                                            <select name="bank_id[]" id="bank_id" class="form-select">
                                                <option value="" selected disabled>Banks</option>
                                                @foreach ($DataBankLists as $bank)
                                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 row align-items-center">
                                        <label class="col-form-label col-4 fw-bold">Pin Code</label>
                                        <div class="col-8">
                                            <input type="number" name="pin_code[]" class="form-control" placeholder="PIN Code">
                                        </div>
                                        </div>
                                        <div class="form-group mb-3 row align-items-center">
                                        <label class="col-form-label col-4 fw-bold">Expiration Date</label>
                                        <div class="col-8">
                                            <input type="month" name="expiration_date[]" class="form-control">
                                        </div>
                                        </div>
                                        <div class="form-group mb-3 row align-items-center">
                                        <label class="col-form-label col-4 fw-bold">Remarks</label>
                                        <div class="col-8">
                                            <input type="text" name="remarks[]" class="form-control" placeholder="Remarks" minlength="0" maxlength="100">
                                        </div>
                                        </div>
                                        <!-- <div class="form-group mb-2 row align-items-center">
                                        <label class="col-form-label col-4 fw-bold">Remove</label>
                                        <div class="col-8">
                                            <a href="#" class="btn btn-danger remove-atm-row"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                        </div> -->
                                    </div>
                                    <hr class="mt-2 mb-2">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closeCreateModal" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // var FetchingDatatableBody = $('#FetchingDatatable tbody');

            // const dataTable = new ServerSideDataTable('#FetchingDatatable');
            // var url = '{!! route('clients.data') !!}';
            // const buttons = [{
            //     text: 'Delete',
            //     action: function(e, dt, node, config) {
            //         // Add your custom button action here
            //         alert('Custom button clicked!');
            //     }
            // }];

            // // const columns = [
            // //     {
            // //         data: null,
            // //         name: 'action',
            // //         render: function(data, type, row) {
            // //             return `
            // //                 <a href="#" class="text-warning editBtn me-2" data-id="${row.id}"
            // //                     data-bs-toggle="tooltip" data-bs-placement="top" title="Edit ">
            // //                     <i class="fas fa-pencil-alt me-2"></i>
            // //                 </a>

            // //                 <a href="#" class="text-danger deleteBtn me-2" data-id="${row.id}"
            // //                     data-bs-toggle="tooltip" data-bs-placement="top" title="Delete ">
            // //                     <i class="fas fa-trash-alt me-2"></i>
            // //                 </a>`;
            // //         },
            // //         orderable: false,
            // //         searchable: false,
            // //     },
            // //     {
            // //         data: null,
            // //         name: 'branch_location',
            // //         render: function(data, type, row, meta) {
            // //             var abbreviation = row.branch_abbreviation ? row.branch_abbreviation : '';
            // //             var separator = row.branch_abbreviation ? ' - ' : '';
            // //             return '<span class="fw-bold h6">' + '<span class="fw-bold h6 text-primary">' + abbreviation + '</span>' + separator + row.branch_location + '</span>';
            // //         },
            // //         orderable: true,
            // //         searchable: true,
            // //     },
            // //     {
            // //         data: 'branch_head',
            // //         name: 'branch_head',
            // //         render: function(data, type, row, meta) {
            // //             return '<span class="fw-bold h6">' + (row.branch_head !== null && row.branch_head !== undefined ? row.branch_head : '') + '</span>'; // Display user's name or empty if null
            // //         },
            // //         orderable: true,
            // //         searchable: true,
            // //     },
            // //     {
            // //         data: 'district_id',
            // //         name: 'district.district_name',
            // //         render: function(data, type, row, meta) {
            // //             return row.district ? '<span>' + row.district.district_name + '</span>' : '';
            // //         },
            // //         orderable: true,
            // //         searchable: true,
            // //     },
            // //     {
            // //         data: 'area_id',
            // //         name: 'district.area',
            // //         render: function(data, type, row, meta) {
            // //             return row.area ? '<span>' + row.area.area_supervisor + '</span>' : '';
            // //         },
            // //         orderable: true,
            // //         searchable: true,
            // //     }

            // // ];
            // dataTable.initialize(url, columns);

            $('.balanceCurrency').inputmask({
                'alias': 'currency',
                allowMinus: false,
                'prefix': "₱ ",
                max: 999999999999.99,
            });

            $('#pension_number_type').on('change', function() {
                var selected_pension_types = $(this).val();

                // Make the AJAX GET request
                $.ajax({
                    url: '/pension/types/fetch',
                    type: 'GET',
                    data: {
                        selected_pension_types: selected_pension_types
                    },
                    success: function(response) {
                        var options = '<option value="" selected disabled>Pension Types</option>';
                        $.each(response, function(index, item) {
                            options += `<option value="${item.id}">${item.pension_name}</option>`;
                        });
                        $('#pension_type').prop('disabled', false); // Remove disabled attribute
                        $('#pension_type').html(options); // Set the dropdown options
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors
                        console.error('AJAX Error:', status, error);
                    }
                });
            });

            $('#createClientModal').on('shown.bs.modal', function () {
                $('#branch_id').select2({ dropdownParent: $('#createClientModal'), });
                $('#pension_type').select2({  dropdownParent: $('#createClientModal') });
            });

            var maxRows = 5; // Maximum number of rows
            var rowCount = $('.atm-details').length; // Initial row count

            // Initialize input mask for existing rows
            applyInputMaskCurrency();
            applyCardNumberInputMask();

            // Add new row on Add button click
            $('#addMoreAtmBtn').click(function(e) {
                e.preventDefault();
                if (rowCount < maxRows) {
                    let newRow = `
                        <div class="row atm-details mt-2">
                            <hr>
                            <label class="fw-bold h6 text-center mb-3 text-primary">
                                Add ATM / Passbook / Simcard No.
                            </label>

                            <hr>
                            <div class="col-md-6">
                                <div class="form-group mb-2 row align-items-center">
                                <label class="col-form-label col-sm-4 fw-bold">Type</label>
                                <div class="col-8">
                                    <select name="atm_type[]" class="form-select" required>
                                    <option value="" selected disabled>Type</option>
                                    <option value="ATM">ATM</option>
                                    <option value="Passbook">Passbook</option>
                                    <option value="Sim Card">Sim Card</option>
                                    </select>
                                </div>
                                </div>
                                <div class="form-group mb-2 row align-items-center">
                                <label class="col-form-label col-sm-4 fw-bold">ATM / Passbook / Sim No.</label>
                                <div class="col-8">
                                    <input type="text" name="atm_number[]" class="atm_card_input_mask form-control" placeholder="ATM / Passbook / Sim No." required>
                                </div>
                                </div>
                                <div class="form-group mb-3 row align-items-center">
                                <label class="col-form-label col-4 fw-bold">Balance</label>
                                <div class="col-8">
                                    <input type="text" name="atm_balance[]" class="balanceCurrency form-control" value="0" placeholder="Balance" required>
                                </div>
                                </div>
                                <div class="form-group mb-2 row align-items-center">
                                <label class="font-size col-form-label col-4 fw-bold">Banks</label>
                                <div class="col-8">
                                    <div class="form-group">
                                    <select name="bank_id[]" id="bank_id" class="form-select">
                                        <option value="" selected disabled>Banks</option>
                                        @foreach ($DataBankLists as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3 row align-items-center">
                                <label class="col-form-label col-4 fw-bold">Pin Code</label>
                                <div class="col-8">
                                    <input type="number" name="pin_code[]" class="form-control" placeholder="PIN Code">
                                </div>
                                </div>
                                <div class="form-group mb-3 row align-items-center">
                                <label class="col-form-label col-4 fw-bold">Expiration Date</label>
                                <div class="col-8">
                                    <input type="month" name="expiration_date[]" class="form-control">
                                </div>
                                </div>
                                <div class="form-group mb-3 row align-items-center">
                                <label class="col-form-label col-4 fw-bold">Remarks</label>
                                <div class="col-8">
                                    <input type="text" name="remarks[]" class="form-control" placeholder="Remarks" minlength="0" maxlength="100">
                                </div>
                                </div>
                                <!-- <div class="form-group mb-2 row align-items-center">
                                <label class="col-form-label col-4 fw-bold">Remove</label>
                                <div class="col-8">
                                    <a href="#" class="btn btn-danger remove-atm-row"><i class="fa-solid fa-trash"></i></a>
                                </div>
                                </div> -->
                            </div>
                            <hr class="mt-2 mb-2">
                        </div>`;

                    $('#AddMoreAtmContainer').append(newRow); // Append the new row
                    applyCardNumberInputMask(); // Apply input mask to the new row
                    applyInputMaskCurrency(); // Apply input mask for balance
                    rowCount++; // Increase row count
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Limit of 5 ATM Rows Only!"
                    });
                }
            });

            // Remove row and update the count
            $(document).on('click', '.remove-atm-row', function(e) {
                e.preventDefault();
                if (rowCount > 1) { // Ensure at least one row remains
                    $(this).closest('.atm-details').remove();
                    rowCount--;
                }
            });

            // Function to apply input mask to balance fields
            function applyInputMaskCurrency() {
                $('.balanceCurrency').inputmask({
                    'alias': 'currency',
                    allowMinus: false,
                    'prefix': "₱ ",
                    max: 999999999999.99,
                });
            }

            // Function to apply card number input mask
            function applyCardNumberInputMask() {
                $(".atm_card_input_mask").inputmask({
                    mask: '9999-9999-9999-9999', // Custom mask for the card number
                    placeholder: '', // Placeholder to show the expected format
                    showMaskOnHover: false,  // Hide the mask when the user is not interacting with the field
                    showMaskOnFocus: true,   // Show the mask when the field is focused
                    rightAlign: false       // Align the input to the left
                });
            }

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

                                        // Set the validated pension number in the modal's input field
                                        $('#pension_number_get').val($('#pension_number').val());

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
