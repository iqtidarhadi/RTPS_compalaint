function initializeDataTable(options) {
    var dataTable = $(options.selector);
    var route = options.route || dataTable.data("route");
    var title = options.title || "";

    function collectFilterData() {
        var filters = {};
        $("[data-filter]").each(function () {
            var key = $(this).data("filter");
            filters[key] = $(this).val();
        });
        return filters;
    }

    // Destroy existing DataTable before reinitializing
    if ($.fn.DataTable.isDataTable(options.selector)) {
        $(options.selector).DataTable().clear().destroy();
    }
    var table = dataTable.DataTable({
        pagingType: "full_numbers",
        lengthMenu: [25, 75, 100, 150],
        pageLength: 25,
        processing: true,
        serverSide: true,
        ajax: {
            type: options.method || "GET",
            url: route,
            data: function (d) {
                d._token = $('meta[name="csrf-token"]').attr("content");
                Object.assign(d, collectFilterData());
                // Ensure `options.payload` is merged properly
                if (options.payload && typeof options.payload === "object") {
                    Object.assign(d, options.payload);
                }
            },
        },
        columns: options.columns,
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
            {
                extend: "collection",
                className: "btn btn-label-primary dropdown-toggle me-2",
                text: '<i class="bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                buttons: [
                    {
                        extend: "print",
                        text: '<i class="bx bx-printer me-1"></i>Print',
                        className: "dropdown-item",
                    },
                    {
                        extend: "csv",
                        text: '<i class="bx bx-file me-1"></i>CSV',
                        className: "dropdown-item",
                    },
                    {
                        extend: "excel",
                        text: '<i class="bx bxs-file-export me-1"></i>Excel',
                        className: "dropdown-item",
                    },
                    {
                        extend: "pdf",
                        text: '<i class="bx bxs-file-pdf me-1"></i>PDF',
                        className: "dropdown-item",
                    },
                    {
                        extend: "copy",
                        text: '<i class="bx bx-copy me-1"></i>Copy',
                        className: "dropdown-item",
                    },
                ],
            },
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return "Details of " + data["name"];
                    },
                }),
                type: "column",
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col) {
                        return col.title !== ""
                            ? '<tr data-dt-row="' +
                                  col.rowIndex +
                                  '" data-dt-column="' +
                                  col.columnIndex +
                                  '">' +
                                  "<td>" +
                                  col.title +
                                  ":</td> " +
                                  "<td>" +
                                  col.data +
                                  "</td>" +
                                  "</tr>"
                            : "";
                    }).join("");
                    return data
                        ? $('<table class="table"/><tbody />').append(data)
                        : false;
                },
            },
        },
    });

    // Set table title
    $("div.head-label").html('<h5 class="card-title mb-0">' + title + "</h5>");

    // Check permission and add "Add New" button
    if (options.canCreate) {
        table
            .buttons()
            .container()
            .append(
                '<button class="create-new btn btn-primary" onclick="window.location.href=\'' +
                    options.createRoute +
                    "'\">" +
                    '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Record</span>' +
                    "</button>"
            );
    }

    // Reload DataTable on button click
    if (options.reloadButtonSelector) {
        $(options.reloadButtonSelector)
            .off("click")
            .on("click", function () {
                dataTable.DataTable().clear().destroy();
                initializeDataTable(options);
            });
    }
}

//delete Function

function destroy(element, deleteUrl) {
    if (confirm("Are you sure you want to delete this record?")) {
        $.ajax({
            url: deleteUrl,
            type: "POST", // Use POST instead of DELETE
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                _method: "DELETE", // Laravel will interpret this as a DELETE request
            },
            success: function (response) {
                $(element).closest("table").DataTable().ajax.reload();
            },
            error: function (xhr) {
                alert("Failed to delete record!");
            },
        });
    }
}
