var Model = Model || {};

Model.Menu = Backbone.Model.extend({
    getParent: function() {
        if (this.collection) {
            return this.collection.get(this.get('parent'));
        }
    },

    getChildren: function() {
        if (this.collection) {
            return this.collection.where({parent: this.get('id')});
        }
    }
});