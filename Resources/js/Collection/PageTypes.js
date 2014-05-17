var Collection = Collection || {};

Collection.PageTypes = Backbone.Collection.extend({
    model: Model.PageType,

    getList: function(parent) {
        var pagetypes = [];
        if (typeof parent !== "undefined") {
            parent = this.get(parent);
            this.each(function(type) {
                if (parent.isAllowed(type)) {
                    pagetypes.push(type);
                }
            });
            return pagetypes;
        } else {
            return this.where({showInList: true});
        }

    }
});