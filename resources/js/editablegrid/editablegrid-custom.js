/**
 * @author: goodluck mlwilo
 * @email:nivalamata@gmail.com
 * @on: ${DATE}
 * @time:${TIME}
 */
//helper function to get path of a demo image
function image(relativePath) {
    return "images/" + relativePath;
}

//create product editable table
var voucherGrid = new EditableGrid("Product", {
    pageSize: 10,
    maxBars: 10
});

//create timeslot editable table
var timeSlotGrid = new EditableGrid("TimeSlot", {
    pageSize: 10,
    maxBars: 10
});
EditableGrid.prototype.addTimeSlotRow = function () {
    with (this) {
        $("#modal-slot-add").on("click", function () {
            addNewRow(timeSlotGrid);
        });
    }

};

EditableGrid.prototype.addNewRow = function (grid) {
    with (this) {
        var newRowId = 0;
        var count = grid.getRowCount();
        for (var r = 0; r < grid.getRowCount(); r++) newRowId = Math.max(newRowId, parseInt(count));
        var values = this.getRowValues(count - 1);
        values['qty_left'] = 0;
        values['no'] = count + 1;
        // add new row
        grid.insertAfter(count - 1, newRowId, values);

    }


};

EditableGrid.prototype.onLoadTimeSlotGrid = function (tableId) {
    // metadata are built in Javascript: we give for each column a name and a type
    this.load({
        metadata: [
            {name: "no", datatype: "integer", editable: false},
            {name: "from", datatype: "time", editable: true},
            {name: "to", datatype: "time", editable: true},
            {name: "price", datatype: "integer", editable: true},
            {name: "qty_left", datatype: "integer", editable: true},
            {name: "action", datatype: "html", editable: false},

        ]
    });

    // attach grid to existing table
    this.attachToHTMLTable(_$(tableId));
    this.addTimeSlotActionColumn(timeSlotGrid)
    this.renderGrid();
    this.addTimeSlotRow();
    this.onTimeSlotGridChange();
};


EditableGrid.prototype.addTimeSlotActionColumn = function (grid) {
    with (this) {
        // render for the action column
        setCellRenderer("action", new CellRenderer({
            render: function (cell, value) {
                // this action will remove the row, so first find the ID of the row containing this cell
                var rowId = grid.getRowId(cell.rowIndex);

                cell.innerHTML = "<a onclick=\"if (confirm('Are you sure you want to delete Timeslot ? ')) {" +
                    " grid.remove(" + cell.rowIndex + "); " +
                    "} \" style=\"cursor:pointer\">" +
                    "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>";


            }
        }));
    }

}

EditableGrid.prototype.onTimeSlotGridChange = function () {
    with (this) {
        modelChanged = function (rowIndex, columnIndex, oldValue, newValue, row) {

            console.log("count: " + getRowCount(), "rowId: " + getRowId(rowIndex), "columnName: " + getColumnName(columnIndex));
            console.log("rowIndex: " + rowIndex, "columnIndex: " + columnIndex, "oldValue: " + oldValue, "newValue: " + newValue, "row: " + row.cells);

        };
    }

}

EditableGrid.prototype.onTimeSlotRowRemoved = function () {
    with (this) {
        rowRemoved = function (oldRowIndex, rowId) {
            console.log("Removed row '" + oldRowIndex + "' - ID = " + rowId);
        };
    }

}


EditableGrid.prototype.addVoucherValidation = function () {
    with (this) {
        addCellValidator("retail", new CellValidator({
            isValid: function (value) {
                return (parseInt(value) >= 0);
            }
        }));
    }

}
EditableGrid.prototype.addVoucherStyles = function () {
    with (this) {
        getColumn("name").cellEditor.minWidth = 300;
    }

}

EditableGrid.prototype.onVoucherGridChange = function () {
    with (this) {
        modelChanged = function (rowIndex, columnIndex, oldValue, newValue, row) {
            console.log("rowIndex: " + rowIndex, "columnIndex: " + columnIndex, "oldValue: " + oldValue, "newValue: " + newValue, "row: " + row);

        };
    }

}


//this function will initialize our editable grid
EditableGrid.prototype.initializeGrid = function () {
    with (this) {
        // render the grid to dom,parameters ignored if table is already attached
        renderGrid();

    }
}

//add grid filters
EditableGrid.prototype.addVoucherFilters = function (grid) {
    with (this) {
        // update paginator whenever the table is rendered (after a sort, filter, page change, etc.)
        tableRendered = function () {
            this.updatePaginator();
        };

        // set active (stored) filter if any
        _$('filter').value = currentFilter ? currentFilter : '';

        // filter when something is typed into filter
        _$('filter').onkeyup = function () {
            grid.filter(_$('filter').value);
        };

        // bind page size selector
        $('#pagesize').val(pageSize).change(function () {
            grid.setPageSize($('#pagesize').val());
        });
    }
};

EditableGrid.prototype.onloadVoucherDetails = function (tableId) {
    // metadata are built in Javascript: we give for each column a name and a type
    this.load({
        metadata: [
            {name: "no", datatype: "integer", editable: false},
            {name: "type", datatype: "string", editable: true},
            {name: "o", datatype: "boolean", editable: true},
            {name: "smm", datatype: "boolean", editable: true},
            {name: "date", datatype: "date", editable: true},
            {name: "voucher id", datatype: "string", editable: true},
            {name: "name", datatype: "string", editable: true},
            {name: "brand", datatype: "string", editable: true},
            {name: "category", datatype: "string", editable: true},
            {name: "sub category", datatype: "string", editable: true},
            {name: "retail", datatype: "double", editable: true},
            {name: "discounted", datatype: "html", editable: false}
        ]
    });

    // attach grid to existing table
    this.attachToHTMLTable(_$(tableId));
    this.addVoucherStyles();
    this.addVoucherValidation();
    this.renderGrid();
    this.addVoucherFilters(voucherGrid);
    this.onVoucherGridChange()
};


//function to render the paginator control
EditableGrid.prototype.updatePaginator = function () {
    var paginator = $("#paginator").empty();
    var nbPages = this.getPageCount();

    // get interval
    var interval = this.getSlidingPageInterval(20);
    if (interval == null) return;

    // get pages in interval (with links except for the current page)
    var pages = this.getPagesInInterval(interval, function (pageIndex, isCurrent) {
        if (isCurrent) return "" + (pageIndex + 1);
        return $("<a>").css("cursor", "pointer").html(pageIndex + 1).click(function (event) {
            voucherGrid.setPageIndex(parseInt($(this).html()) - 1);
        });
    });

    // "first" link
    var link = $("<a>").html("<img src='" + image("gofirst.png") + "'/>&nbsp;");
    if (!this.canGoBack()) link.css({opacity: 0.4, filter: "alpha(opacity=40)"});
    else link.css("cursor", "pointer").click(function (event) {
        voucherGrid.firstPage();
    });
    paginator.append(link);

    // "prev" link
    link = $("<a>").html("<img src='" + image("prev.png") + "'/>&nbsp;");
    if (!this.canGoBack()) link.css({opacity: 0.4, filter: "alpha(opacity=40)"});
    else link.css("cursor", "pointer").click(function (event) {
        voucherGrid.prevPage();
    });
    paginator.append(link);

    // pages
    for (p = 0; p < pages.length; p++) paginator.append(pages[p]).append(" | ");

    // "next" link
    link = $("<a>").html("<img src='" + image("next.png") + "'/>&nbsp;");
    if (!this.canGoForward()) link.css({opacity: 0.4, filter: "alpha(opacity=40)"});
    else link.css("cursor", "pointer").click(function (event) {
        voucherGrid.nextPage();
    });
    paginator.append(link);

    // "last" link
    link = $("<a>").html("<img src='" + image("golast.png") + "'/>&nbsp;");
    if (!this.canGoForward()) link.css({opacity: 0.4, filter: "alpha(opacity=40)"});
    else link.css("cursor", "pointer").click(function (event) {
        voucherGrid.lastPage();
    });
    paginator.append(link);
};