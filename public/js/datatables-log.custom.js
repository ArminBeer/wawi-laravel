jQuery(function ($) {

    var table = jQuery('.js-dataTable').dataTable({
        paging: true,
        pageLength: 50,
        bAutoWidth : false,
        order: [[ 0, 'DESC']],
        language: {
            decimal: "",
            emptyTable: "Keine Logs verfügbar",
            info:           "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
            infoEmpty:      "",
            infoFiltered:   "(gefiltert von _MAX_ gesamten Einträgen)",
            infoPostFix:    "",
            thousands:      ".",
            lengthMenu:     "Zeige _MENU_ Einträge",
            loadingRecords: "Lädt...",
            processing:     "Verarbeitet...",
            search:         "Suche: ",
            zeroRecords:    "Keine Treffer gefunden",
            paginate: {
                first:      "Erste",
                last:       "Letzte",
                next:       "Nächste",
                previous:   "Vorher"
            },
            aria: {
                sortAscending: ": aktivieren um Spalten absteigend zu sortieren",
                sortDescending: ": aktivieren um Spalten aufsteigend zu sortieren"
            }
        }
    });

    $('.dataTables_length').addClass('hidden');

    $('#datepicker').on('input', function(){
        var inputDate = $('#datepicker').val();
        var dateArray = inputDate.split('-');
        var newDate = dateArray[2] + '.' + dateArray[1] + '.' + dateArray[0];
        $('.js-dataTable').DataTable().column(0).search(newDate).draw();
    });

    $('.filter-opener').on('click', function() {
        $('.filter-wrapper').toggleClass('hidden');
        $('.dataTables_length').toggleClass('hidden');
    });


});
