var Collection = Collection || {};

Collection.Routes = Backbone.Collection.extend({
    model: Model.Route,


    getLanguage: function(lang) {
        return this.get("/cms/routes/" + lang);
    },

    comparator: 'id',

    getPage: function(id) {
        return this.get("/cms/routes/" + id);
    },

    getLanguages: function() {
        return this.where({
            "parent": "/cms/routes"
        })
    }
});