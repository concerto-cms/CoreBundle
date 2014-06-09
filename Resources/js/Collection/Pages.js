var Collection = Collection || {};

Collection.Pages = Backbone.Collection.extend({
    model: Model.Page,
    comparator: 'id',

    getLanguages: function() {
        return this.where({
            "parent": ""
        })
    }
});