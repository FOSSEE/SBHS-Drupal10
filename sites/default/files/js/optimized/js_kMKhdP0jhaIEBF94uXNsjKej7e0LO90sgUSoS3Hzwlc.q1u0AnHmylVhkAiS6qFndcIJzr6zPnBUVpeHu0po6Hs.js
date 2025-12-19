/* Source and licensing information for the line(s) below can be found at http://localhost/SBHS-D10/core/modules/comment/comment-entity-form.js. */
/**
 * @file
 * Attaches comment behaviors to the entity form.
 */

(function ($, Drupal) {
  /**
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.commentFieldsetSummaries = {
    attach(context) {
      const $context = $(context);
      $context
        .find('fieldset.comment-entity-settings-form')
        .drupalSetSummary((context) =>
          Drupal.checkPlain(
            $(context)
              .find('.js-form-item-comment input:checked')
              .next('label')[0].textContent,
          ),
        );
    },
  };
})(jQuery, Drupal);

/* Source and licensing information for the above line(s) can be found at http://localhost/SBHS-D10/core/modules/comment/comment-entity-form.js. */