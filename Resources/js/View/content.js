var Concerto = Concerto || {};
Concerto.View = Concerto.View || {};

Concerto.View.Content = {
    init: function(data) {
        var that = this,
            router;

        _.each(data.languages, function(language) {
            language.pages = new Concerto.Collection.Routes(language.pages);
        });

        this.pages = new Concerto.Collection.Routes(data.pages);
        this.languages = data.languages;
        this.splash = data.splash;

        // Setup router
        this.contentContainer = document.getElementById("contentContainer");

        router = Backbone.Router.extend({
            routes: {
                "splash":                 "editSplash",
                ":lang":                  "language",
                ":lang/:page":            "editPage"
            },

            editSplash: function() {
                that.contentContainer.innerHTML = window.JST["content.editSplash.html.twig"].render({
                    languages: that.languages
                });
            },

            language: function(lang) {
                var language = that.languages[lang];
                that.contentContainer.innerHTML = window.JST["content.language.html.twig"].render({
                    languages: that.languages,
                    language: language,
                    page: that.pages.getLanguage(lang)
                });
            },

            editPage: function(lang, page) {
                that.contentContainer.innerHTML = window.JST["content.edit.html.twig"].render({

                });
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

    }
};

_.extend(Concerto.View.Content, Backbone.Events);
