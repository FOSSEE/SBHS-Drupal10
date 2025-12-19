/* Source and licensing information for the line(s) below can be found at http://localhost/SBHS-D10/core/modules/statistics/statistics.js. */
/**
 * @file
 * Statistics functionality.
 */

(function ($, drupalSettings) {
  setTimeout(() => {
    $.ajax({
      type: 'POST',
      cache: false,
      url: drupalSettings.statistics.url,
      data: drupalSettings.statistics.data,
    });
  });
})(jQuery, drupalSettings);

/* Source and licensing information for the above line(s) can be found at http://localhost/SBHS-D10/core/modules/statistics/statistics.js. */