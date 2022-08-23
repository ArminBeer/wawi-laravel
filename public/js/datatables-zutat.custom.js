jQuery(function ($) {

    var table = jQuery('.js-dataTable').dataTable({
        paging: true,
        pageLength: 25,
        bAutoWidth : false,
        language: {
            decimal: "",
            emptyTable: "Keine Zutaten verfügbar",
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

    $('.filter-kategorie select').on('change', function() {
        if( $(this).val() != "") {
            // var regex = '(?=.*' + $(this).val().join(')(?=.*') + ')'; //AND search
            $('.js-dataTable').DataTable().column(4).search($(this).val().join('|'),true,false).draw();
        } else {
            $('.js-dataTable').DataTable().column(4).search("").draw();
        }
    });
    $('.filter-bereich select').on('change', function() {
        $('.js-dataTable').DataTable().column(5).search($(this).val(),false,true).draw();
    });

    $('.filter-opener').on('click', function() {
        $('.filter-wrapper').toggleClass('hidden');
    })
});
