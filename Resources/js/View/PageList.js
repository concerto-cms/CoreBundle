var View = View || {};

View.PageList = Backbone.View.extend({
    initialize: function(options) {
        _.extend(this, options);
        this.render();
    },

    render: function() {
        this.el.innerHTML = window.JST["content.pageList.html.twig"].render({
            page: this.model,
            pageTypes: this.pageTypes,
            languages: this.languages
        });
    },
    events: {
        "click button.new-page": "openNewpageDialog"
    },

    openNewpageDialog: function() {
        window.modal = new View.NewpageDialog({
            languages: this.languages,
            current: this.model,
            pages: this.pages,
            pageTypes: this.pageTypes
        });

    }

});