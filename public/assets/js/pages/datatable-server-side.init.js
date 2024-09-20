class ServerSideDataTable {
    constructor(tableSelector) {
        this.tableSelector = tableSelector;
        this.table = null;
    }

    initialize(url, columns) {
        this.table = $(this.tableSelector).DataTable({
            serverSide: true,
            processing: true,
            ajax: url,
            columns: columns,
            ordering: false,
            drawCallback: function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
                $(".dataTables_paginate > .pagination").addClass( "pagination-rounded");
            },
            language: {
                searchPlaceholder: "Enter to search ...",
                paginate: {
                    previous: "<button class='btn btn-light'>Previous</button>",
                    next: "<button class='btn btn-light'>Next</button>",
                },
                processing: function () {
                    Swal.fire({
                        title: "Please Wait...",
                        text: "Please wait for a moment",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                    return "Please wait for a moment ....";
                },
            },
        });

        $(this.tableSelector)
            .on("length.dt", function (e, settings, len) {
                // Show a custom processing message when changing the number of entries
                Swal.fire({
                    title: "Please Wait...",
                    text: "Please wait for a moment",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
            })
            .on("draw.dt", function () {
                Swal.close();
            });
        // $(this.tableSelector + "_wrapper .dataTables_filter").hide();
    }
    updateSearchQuery(query) {
        if (this.table) {
            this.table.search(query).draw();
        }
    }
}
