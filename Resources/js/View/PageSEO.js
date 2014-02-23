var Concerto = Concerto || {};
Concerto.View = Concerto.View || {};

Concerto.View.PageSEO = Backbone.View.extend({
    initialize: function() {

    },

    render: function() {
        this.el.innerHTML = window.JST["content.pageSEO.html.twig"].render({
        });
    },
    events: {

    }

});