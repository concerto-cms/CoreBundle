var Model = Model || {};

Model.Route = Backbone.Model.extend({
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

    getContent: function() {
        return this.get('content');
    },

    set: function(attributes, options) {
        if (attributes === "content" && !(options instanceof Concerto.Model.Page)) {
            options = new Model.Page(options);
        }

        if (typeof attributes === "object" && typeof attributes.content !== "undefined") {
            attributes.content = new Model.Page(attributes.content);
        }

        Backbone.Model.prototype.set.apply(this, arguments);
    },

    getId: function() {
        return this.get('id').replace("/cms/routes/", "");
    },

    getLanguage: function() {
        var idParts = this.getId().split("/");
        return this.collection.getLanguage(_.first(idParts));
    }

});