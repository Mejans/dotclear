/*global $, reorder, dotclear */
'use strict';

$(function() {
  // clean
  $('.remove-if-drag').remove();
  $('.hidden-if-drag').hide();
  $('.widgets, .sortable-delete').addClass('if-drag');

  // move
  $('.connected, .sortable-delete').sortable({
    tolerance: 'move',
    cursor: 'move',
    axis: 'y',
    dropOnEmpty: true,
    handle: '.widget-name',
    placeholder: 'ui-sortable-placeholder',
    items: 'li:not(.sortable-delete-placeholder,.empty-widgets)',
    connectWith: '.connected, .sortable-delete',
    start: function(event, ui) {
      // petit décalage esthétique
      ui.item.css('left', ui.item.position().left + 20);
    },
    update: function(event, ui) {
      var ul = $(this);
      var widget = ui.item;
      var field = ul.parents('.widgets');

      // met a zéro le décalage
      ui.item.css('left', 'auto');
      // Fixes issue #2080
      ui.item.css('width', 'auto');
      ui.item.css('height', 'auto');

      // signale les zones vides
      if (ul.find('li:not(.empty-widgets)').length == 0) {
        ul.find('li.empty-widgets').show();
        field.find('ul.sortable-delete').hide();
      } else {
        ul.find('li.empty-widgets').hide();
        field.find('ul.sortable-delete').show();
      }

      // remove
      if (widget.parents('ul').is('.sortable-delete')) {
        widget.hide('slow', function() {
          $(this).remove();
        });
      }

      // réordonne
      reorder(ul);

      // expand
      if (widget.find('img.expand').length == 0) {
        dotclear.postExpander(widget);
        dotclear.viewPostContent(widget, 'close');
      }
    }
  });

  // add
  $('#widgets-ref > li').draggable({
    tolerance: 'move',
    cursor: 'move',
    connectToSortable: '.connected',
    helper: 'clone',
    revert: 'invalid',
    start: function(event, ui) {
      ui.helper.css({
        'width': $('#widgets-ref > li').css('width')
      });
    }
  });

  $('li.ui-draggable, ul.ui-sortable li')
    .not('ul.sortable-delete li, li.empty-widgets')
    .css({
      'cursor': 'move'
    });
});