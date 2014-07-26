var Controller = Controller || {};

Controller.Content = function(options) {
    var router;

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
            "":                       "index",
            ":lang":                  "list",
            ":lang/*id":              "edit"
        }
    });
    this.router = new router();
    this.listenTo(this.router, "route:index", this.indexAction);
    this.listenTo(this.router, "route:list", this.listAction);
    this.listenTo(this.router, "route:edit", this.editAction);

    Backbone.history.start()
};
_.extend(Controller.Content.prototype, Backbone.Events);
_.extend(Controller.Content.prototype, {
    indexAction: function() {
        var languages = this.pages.getLanguages();
        if (languages.length > 0) {
            this.router.navigate(languages[0].get('language').prefix, {trigger: true});
        } else {
            // @todo show an error page saying there are no languages
            alert("No languages");
        }
    },
    listAction: function(lang) {
        var language = this.pages.get(lang),
            view = new View.PageList({
                languages: this.pages.getLanguages(),
                pageTypes: this.pageTypes,
                model: language,
                pages: this.pages
            });
        this.cleanup();
        $(this.contentContainer)
            .append(view.$el);
        this.views.push(view);

    },
    editAction: function(lang, id) {
        var collection = this.pages,
            language = collection.get(lang),
            page = collection.get(id),
            header = new View.PageHeader({
                page: page,
                language: language
            }),
            pageType = this.pageTypes.get(page.get('type')),
            model = page.clone(),
            content = pageType.createView({
                model: model,
                language: language
            });
        //page.url = Routing.generate('concerto_cms_core_content_rest', {path: page.id});
        this.listenTo(content, "save", function() {
            page.set(model.attributes);
            page.save();
        })
        this.listenTo(content, "delete", function() {
            var url = language.get('slug');
            collection.remove(model);
            model.destroy();
            this.router.navigate(url, {trigger: true});
        })
        this.cleanup();
        $(this.contentContainer)
            .append(header.$el)
            .append(content.$el);

        this.views.push(header);
        this.views.push(content);
    },
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