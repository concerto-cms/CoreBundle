var Concerto = Concerto || {};
Concerto.View = Concerto.View || {};

Concerto.View.PageContent = Backbone.View.extend({
    initialize: function() {

    },

    render: function() {
        this.el.innerHTML = window.JST["content.pageContent.html.twig"].render({
        });
    },
    events: {

    }

});