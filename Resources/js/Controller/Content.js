var Controller = Controller || {};

Controller.Content = function(options) {
    var that = this,
        router;

    this.views = [];
    this.pageTypes = new Collection.PageTypes(options.pageTypes);
    this.pages = new Collection.Routes(options.pages, {
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
            var language = that.pages.getLanguage(lang),
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
            var language = that.pages.getLanguage(lang),
                route = that.pages.getPage(id),
                header = new View.PageHeader({
                    page: route.getContent(),
                    route: route,
                    language: language
                }),
                pageType = that.pageTypes.get(route.getContent().get('type')),
                content;


            content = pageType.createView({
                page: route.getContent(),
                route: route,
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
                that.router.navigate(languages[0].get('name'), {trigger: true});
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
        this.router.navigate(page.getLanguage().get('name') + "/" + page.getId(), {trigger: true});
    }
});