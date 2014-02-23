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


};
_.extend(Concerto.Controller.Content, Backbone.Events);