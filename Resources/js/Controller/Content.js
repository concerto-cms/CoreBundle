var Concerto = Concerto || {};
Concerto.Controller = Concerto.Controller || {};

Concerto.Controller.Content = function(data) {
    var that = this,
        router;

    this.pages = new Concerto.Collection.Routes(data);
    this.contentContainer = document.getElementById("contentContainer");

    // Setup router
    router = Backbone.Router.extend({
        routes: {
            ":lang":                  "language",
            ":lang/:id":            "editPage",
            "new":                    "newPage"
        },

        language: function(lang) {
            var language = that.pages.getLanguage(lang),
                view = new Concerto.View.PageList({
                    languages: that.pages.getLanguages(),
                    model: language
                });
            $(that.contentContainer)
                .html("")
                .append(view.$el);
        },

        editPage: function(lang, id) {
            var language = that.pages.getLanguage(lang),
                page = that.pages.getPage(id),
                header = new Concerto.View.PageHeader({
                    model: page
                }),
                content = new Concerto.View.PageContent({
                    model: page
                });
            $(that.contentContainer)
                .html("")
                .append(header.$el)
                .append(content.$el);
        }

    });
    this.router = new router();

    if (!Backbone.history.start()) {
        // Go to the first language
        var languages = this.pages.getLanguages();
        if (languages.length > 0) {
            this.router.navigate(languages[0].get('prefix'), {trigger: true});
        } else {
            // @todo show an error page saying there are no languages
        }
    }


};
_.extend(Concerto.Controller.Content, Backbone.Events);