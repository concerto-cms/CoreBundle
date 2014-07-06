var View = View || {};

View.PageHeader = Backbone.View.extend({
    initialize: function(options) {
        this.model = options.page;
        this.language = options.language;
        this.route = options.route;
        this.render();
        this.listenTo(this.model, "change", this.render);
    },

    render: function() {
        this.el.innerHTML = window.JST["content.pageHeader.html.twig"].render({
            route: this.route,
            page: this.model,
            language: this.language
        });
    },
    events: {

    }

});