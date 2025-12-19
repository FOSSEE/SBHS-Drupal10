/* Source and licensing information for the line(s) below can be found at http://localhost/SBHS-D10/core/modules/toolbar/js/escapeAdmin.js. */
/**
 * @file
 * Replaces the home link in toolbar with a back to site link.
 */

(function ($, Drupal, drupalSettings) {
  const pathInfo = drupalSettings.path;
  const escapeAdminPath = sessionStorage.getItem('escapeAdminPath');
  const windowLocation = window.location;

  // Saves the last non-administrative page in the browser to be able to link
  // back to it when browsing administrative pages. If there is a destination
  // parameter there is not need to save the current path because the page is
  // loaded within an existing "workflow".
  if (
    !pathInfo.currentPathIsAdmin &&
    !/destination=/.test(windowLocation.search)
  ) {
    sessionStorage.setItem('escapeAdminPath', windowLocation);
  }

  /**
   * Replaces "Back to site" link url when appropriate.
   *
   * Back to site link points to the last non-administrative page the user
   * visited within the same browser tab.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the replacement functionality to the toolbar-escape-admin element.
   */
  Drupal.behaviors.escapeAdmin = {
    attach() {
      const toolbarEscape = once('escapeAdmin', '[data-toolbar-escape-admin]');
      if (
        toolbarEscape.length &&
        pathInfo.currentPathIsAdmin &&
        escapeAdminPath !== null
      ) {
        $(toolbarEscape).attr('href', escapeAdminPath);
      }
    },
  };
})(jQuery, Drupal, drupalSettings);

/* Source and licensing information for the above line(s) can be found at http://localhost/SBHS-D10/core/modules/toolbar/js/escapeAdmin.js. */