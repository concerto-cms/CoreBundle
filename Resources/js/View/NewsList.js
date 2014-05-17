var View = View || {};

View.NewsList = Backbone.View.extend({
    initialize: function(options) {
        _.extend(this, options);
        this.render();
    },

    render: function() {
        this.el.innerHTML = window.JST["news.list.html.twig"].render(this);
    },
    events: {
    },
    getPlanned: function() {
        return this.news.where({planned: true});
    },
    getPublished: function() {
        return this.news.where({published: true});
    },
    getArchived: function() {
        return this.news.where({archived: true});
    }


});