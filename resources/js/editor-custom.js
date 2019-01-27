/**
 * @author: goodluck mlwilo
 * @email:nivalamata@gmail.com
 * @on: 7/10/16
 * @time:1:34 AM
 */
var editor, voucherRoute, voucherColumn;


$().ready(function () {

    editor = new $.fn.dataTable.Editor({
        ajax: $("#tab-voucher-detail").data('product-voucher-route'),
        table: "#tab-voucher-detail",
        fields: [{
            label: "No:",
            name: "no"
        }, {
            label: "O:",
            name: "oshop_selected",
            type: "checkbox",
            separator: "|",
            options: [
                {label: '', value: 1}
            ]
        }, {
            label: "SMM:",
            name: "smm_selected",
            type: "checkbox",
            separator: "|",
            options: [
                {label: '', value: 1}
            ]
        }, {
            label: "Date:",
            name: "created_at",
            type: "datetime",
            def: function () {
                return new Date();
            },
            format: 'YYYY-MM-DD HH:mm'
        }, {
            label: "Voucher ID:",
            name: "voucher_id"
        }, {
            label: "Name:",
            name: "name"
        }, {
            label: "Brand:",
            name: "brand",
        }, {
            label: "Category:",
            name: "category"
        }, {
            label: "Sub Category:",
            name: "sub_cat"
        }, {
            label: "Retail:",
            name: "retail_price"
        }, {
            label: "Details:",
            name: "details",
            type: "readonly"
        }
        ]
    });

// Activate an inline edit on click of a table cell
    $('#tab-voucher-detail').on('click', 'tbody td:not(:first-child)', function (e) {
        editor.inline(this);
        voucherColumn = $(this).data('column');
        voucherRoute = $(this).closest('tr').data('voucher-route');
    });


    editor.on('preBlur', function (e) {
        updateVoucher(voucherColumn, editor.get(), voucherRoute);
    });
    editor.on('submitSuccess', function (e) {
        console.log('success');
    });

    function updateVoucher(column, data, route) {
        data.column = column;
        $.ajax({
            url: route,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response) {
                    var tr = $('#tab-voucher-detail').find('#' + response.row_id);
                    var td = tr.find('.' + response.col_name)
                    //renderCheck box
                    if (response.cell_value == 0 && (response.col_name =="oshop_selected" || response.col_name =="smm_selected")) {
                       td.html('<input   type="checkbox"/>');
                    } else if (response.cell_value == 1) {
                        td.html('<input checked   type="checkbox"/>');
                    } else {
                        td.html(response.cell_value);
                    }


                }
            }
        });
    }


    //data table
    $("#tab-voucher-detail").DataTable({
        //"dom": "Bfrtip",
        "columns": [
            {"data": "no"},
            {"data": "oshop_selected"},
            {"data": "smm_selected"},
            {"data": "created_at"},
            {"data": "voucher_id"},
            {"data": "name"},
            {"data": "brand"},
            {"data": "category"},
            {"data": "sub_cat"},
            {"data": "retail_price"},
            {null: "details"},


        ]
        ,
        "order": [],
        "scrollX": true,
        "columnDefs": [
            {"targets": 0, "orderable": false,},
            {"targets": 9, "orderable": false,},
            {"targets": 'no-sort', "orderable": false,},
            {"targets": "large", "width": "120px"},
            {"targets": "xlarge", "width": "300px"}
        ],
        "aoColumnDefs": [
            /* Column #0,#1,#2 has no sort function & no icons */
            {"bSortable": false, "aTargets": [0, 1, 2]},
            //add check box to columns
            {
                "render": function (data, type, row) {
                    if (type == 'display') {
                        if (data == 1) {
                            return '<input class="editor-active" type="checkbox" checked name="id[]" value="'
                                + $('<div/>').text(data).html() + '">';
                        } else {
                            return '<input  type="checkbox"  name="id[]" value="'
                                + $('<div/>').text(data).html() + '">';
                        }
                    } else {
                        return data;
                    }

                },
                "targets": [1, 2]
            }
        ],
        "fixedColumns": true


    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();

    });


});

