var Collection = Collection || {};

Collection.Menus = Backbone.Collection.extend({
    model: Model.Menu,

    getMenu: function(name, language) {
        return this.getMenuItem(name + "/" + language);
    },
    getMenuItem: function(id) {
        return this.get('/cms/menu/' + id);
    },

    getMenus: function() {
        return this.where({
            "parent": "/cms/menu"
        })
    }
});