/* Source and licensing information for the line(s) below can be found at http://localhost/SBHS-D10/modules/contrib/superfish/js/superfish.js. */
(function ($, Drupal, once) {
  Drupal.behaviors.superfish = {
    attach(context, drupalSettings) {
      // Take a look at each menu to apply Superfish to.
      $.each(drupalSettings.superfish || {}, function (index, options) {
        $(once('superfish', `ul#${options.id}`, context)).each(function () {
          const $menu = $(this);

          // Check if we are to apply the Supersubs plug-in to it.
          if (options.plugins) {
            if (options.plugins.supersubs) {
              $menu.supersubs(options.plugins.supersubs);
            }
          }

          // Apply Superfish to the menu.
          $menu.superfish(options.sf);
          // Check if we are to apply any other plug-in to it.
          if (options.plugins) {
            if (options.plugins.touchscreen) {
              $menu.sftouchscreen(options.plugins.touchscreen);
            }
            if (options.plugins.smallscreen) {
              $menu.sfsmallscreen(options.plugins.smallscreen);
            }
            if (options.plugins.supposition) {
              $menu.supposition();
            }
          }
        });
      });
    },
  };
})(jQuery, Drupal, once);

/* Source and licensing information for the above line(s) can be found at http://localhost/SBHS-D10/modules/contrib/superfish/js/superfish.js. */