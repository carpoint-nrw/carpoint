/**
 * Datatable class definition.
 *
 * @module public/js/Datatable
 */
export default class Datatable {

  /**
   * Translate front site in datatable.
   *
   * @returns {
   *  {
   *    search: string,
   *    sLengthMenu: string,
   *    processing: string,
   *    paginate: {
   *      next: string,
   *      previous: string
   *    },
   *    info: string
   *  }
   * }
   */
  translateFrontSiteValues() {
    return {
      "search": 'Suchen nach: ',
      "emptyTable": 'Keine Daten vorhanden',
      "infoEmpty": '0 bis 0 von 0 Fahrzeugen',
      "processing": 'Wird bearbeitet',
      "sLengthMenu": 'Fahrzeuge pro Seite _MENU_',
      "info": '_START_ bis _END_ von _TOTAL_ Fahrzeugen',
      "paginate": {
        "previous": 'zurück',
        "next": 'nächste'
      }
    };
  }
}
