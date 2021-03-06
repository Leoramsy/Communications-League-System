<script>
    var statistics_table;
    $(document).ready(function () {
        /***** INIT TABLE *****/
        statistics_table = $('#statistics-table').DataTable({
            processing: true,
            tabIndex: 1,
            pageLength: 20,
            bFilter: false,
            bInfo: false,
            ajax: {
                url: '/match-centre/data',
                type: "GET",
                data: function (d) {
                    d.type = 'statistics';
                }
            },
            columns: [
                {data: null, defaultContent: '', orderable: false, sClass: "selector"},
                {data: "sale_representatives.name"},
                {data: "sale_representatives.tel"},
                {data: null, render: function (data, type, row) {
                        if (row['sale_representatives']['cell'] != "") {
                            return row['sale_representatives']['cell'];
                        } else {
                            return "N/A";
                        }
                    }},
                {data: "sale_representatives.email"}
            ],
            columnDefs: [
                {className: "dt-cell-left", targets: [1, 2, 3, 4]}, //Align table body cells to left                
                {searchable: false, targets: 0}
            ],
            language: {
                emptyTable: "This feature is not available yet, check back later"
            },
            order: [1, 'asc'],
            bLengthChange: false,
            select: {
                style: 'single',
                selector: 'td:first-child'
            }
        });
    }); //End of document
</script>