var Concerto = Concerto || {};
Concerto.View = Concerto.View || {};

Concerto.View.PageList = Backbone.View.extend({
    initialize: function() {
        this.render();
    },

    render: function() {
        this.el.innerHTML = window.JST["content.pageList.html.twig"].render();
    },
    events: {

    }

});