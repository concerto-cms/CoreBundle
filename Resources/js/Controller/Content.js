var Controller = Controller || {};

Controller.Content = function(options) {
    var that = this,
        router;

    this.views = [];
    this.pageTypes = new Collection.PageTypes(options.pageTypes);
    this.pages = new Collection.Pages(options.pages, {
        pageTypes: this.pageTypes
    });

    this.contentContainer = document.getElementById("contentContainer");

    this.listenTo(this.pages, "add", this.onAddPage);
    // Setup router
    router = Backbone.Router.extend({
        routes: {
            "":                       "firstLanguage",
            ":lang":                  "language",
            ":lang/*id":              "editPage",
            ":lang/new":              "newPage"
        },

        language: function(lang) {
            var language = that.pages.get(lang),
                view = new View.PageList({
                    languages: that.pages.getLanguages(),
                    pageTypes: that.pageTypes,
                    model: language,
                    pages: that.pages
                });
            that.cleanup();
            $(that.contentContainer)
                .append(view.$el);
            that.views.push(view);
        },

        editPage: function(lang, id) {
            var language = that.pages.get(lang),
                page = that.pages.get(id),
                header = new View.PageHeader({
                    page: page,
                    language: language
                }),
                pageType = that.pageTypes.get(page.get('type')),
                content;


            content = pageType.createView({
                page: page,
                language: language
            });
            that.cleanup();
            $(that.contentContainer)
                .append(header.$el)
                .append(content.$el);

            that.views.push(header);
            that.views.push(content);
        },
        firstLanguage: function() {
            var languages = that.pages.getLanguages();
            if (languages.length > 0) {
                that.router.navigate(languages[0].get('language').prefix, {trigger: true});
            } else {
                // @todo show an error page saying there are no languages
                alert("No languages");
            }

        }

    });
    this.router = new router();

    Backbone.history.start()
};
_.extend(Controller.Content.prototype, Backbone.Events);
_.extend(Controller.Content.prototype, {
    cleanup: function() {
        _.each(this.views, function(view) {
            view.remove();
        });
        this.views = [];
    },
    onAddPage: function(page) {
        this.router.navigate(page.getLanguage().get('slug') + "/" + page.id, {trigger: true});
    }
});