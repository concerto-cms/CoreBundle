var Concerto = Concerto || {};
Concerto.View = Concerto.View || {};

Concerto.View.PageHeader = Backbone.View.extend({
    initialize: function() {
        this.render();
    },

    render: function() {
        this.el.innerHTML = window.JST["content.pageHeader.html.twig"].render({
        });
    },
    events: {

    }

});