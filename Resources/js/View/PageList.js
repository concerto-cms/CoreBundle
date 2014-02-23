var Concerto = Concerto || {};
Concerto.View = Concerto.View || {};

Concerto.View.PageList = Backbone.View.extend({
    initialize: function(options) {
        this.languages = options.languages;
        this.render();
    },

    render: function() {
        this.el.innerHTML = window.JST["content.pageList.html.twig"].render({
            page: this.model,
            languages: this.languages
        });
    },
    events: {

    }

});