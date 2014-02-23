var Concerto = Concerto || {};
Concerto.Collection = Concerto.Collection || {};

Concerto.Collection.Routes = Backbone.Collection.extend({
    model: Concerto.Model.Route,


    getLanguage: function(lang) {
        return this.get("/cms/pages/" + lang);
    },

    getPage: function(id) {
        return this.get("/cms/pages/" + id);
    },

    getLanguages: function() {
        return this.where({
            "parent": "/cms/pages"
        })
    }
});