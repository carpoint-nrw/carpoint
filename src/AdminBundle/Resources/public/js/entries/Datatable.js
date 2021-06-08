/**
 * Datatable class definition.
 *
 * @module public/js/entries/Datatable
 */
export default class Datatable {

  /**
   * Translate default values in datatable.
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
  translateDefaultValues() {
    if (userLocale !== '') {
      return {
        "search": userLocale === 'de' ? 'Suche' : 'Szukaj',
        "processing": userLocale === 'de' ? 'Wird bearbeitet' : 'Przetwarzanie',
        "sLengthMenu": userLocale === 'de' ? 'Einträge _MENU_ anzeigen' : 'Pokaż _MENU_ wpisy',
        "info": userLocale === 'de' ? 'Zeige _START_ bis _END_ von _TOTAL_ Einträgen' : 'Pokazuje _START_ do _END_ z _TOTAL_ wpisów',
        "paginate": {
          "previous": userLocale === 'de' ? 'Bisherige' : 'Poprzedni',
          "next": userLocale === 'de' ? 'Nächster' : 'Kolejny'
        }
      };
    }
  }
}
