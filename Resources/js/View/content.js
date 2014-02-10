var Concerto = Concerto || {};
Concerto.View = Concerto.View || {};

Concerto.View.Content = {
    init: function() {
        // Setup router
        this.router = new Backbone.Router.extend({
            routes: {
                "splash":                 "editSplash",
                ":lang":                  "language",
                ":lang/:page":            "editPage"
            },

            editSplash: function() {

            },

            language: function() {

            },

            editPage: function() {

            }

        })();


        if (!Backbone.history.start()) {
            // Go to the first language
        }
    }
};

_.extend(Concerto.View.Content, Backbone.Events);
