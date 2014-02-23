var Concerto = Concerto || {};
Concerto.Model = Concerto.Model || {};

Concerto.Model.Route = Backbone.Model.extend({
    getParent: function() {
        if (this.collection) {
            return this.collection.get(this.get('parent'));
        }
    },

    getChildren: function() {
        if (this.collection) {
            return this.collection.where({parent: this.get('id')});
        }
    },

    getId: function() {
        return this.get('id').replace("/cms/pages", "");
    }

})