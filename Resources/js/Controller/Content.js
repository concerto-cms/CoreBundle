var Concerto = Concerto || {};
Concerto.Controller = Concerto.Controller || {};

Concerto.Controller.Content = function(data) {
        var that = this,
            router;

        _.each(data.languages, function(language) {
            language.pages = new Concerto.Collection.Routes(language.pages);
        });


        this.pages = new Concerto.Collection.Routes(data.pages);
        this.languages = data.languages;

        // Setup router
        this.contentContainer = document.getElementById("contentContainer");

        router = Backbone.Router.extend({
            routes: {
                ":lang":                  "language",
                ":lang/:page":            "editPage",
                "new":                    "newPage"
            },

            language: function(lang) {
                var language = that.languages[lang],
                    view = new Concerto.View.PageList({
                        languages: that.languages,
                        language: language,
                        page: that.pages.getLanguage(lang)
                    });
                $(that.contentContainer)
                    .html("")
                    .append(view.$el);
            },

            editPage: function(lang, page) {
                var header = new Concerto.View.PageHeader(),
                    content = new Concerto.View.PageContent();
                $(that.contentContainer)
                    .html("")
                    .append(header.$el)
                    .append(content.$el);
            }

        });
        this.router = new router();

        if (!Backbone.history.start()) {
            // Go to the first language
            var languages = _.values(this.languages);
            if (languages.length > 0) {
                this.router.navigate(languages[0].prefix, {trigger: true});
            } else {
                // @todo show an error page saying there are no languages
            }
        }


};
_.extend(Concerto.Controller.Content, Backbone.Events);