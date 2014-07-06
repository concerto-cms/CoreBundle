var Model = Model || {};

Model.Page = Backbone.Model.extend({
    url: function() {
        if (this.id) {
            return Routing.generate('concerto_cms_core_content_rest', {path: this.id});
        } else if (this.has('parent')) {
            return Routing.generate('concerto_cms_core_content_rest', {path: this.get('parent')});
        } else {
            throw "unable to generate url because of missing id and parent";
        }
    },
    initialize: function() {
        this.on("sync", function() {
            $.growl({
                title: 'De pagina is opgeslagen',
                icon: 'glyphicon glyphicon-saved'
            },{ type: 'success' });
        })
    },
    getParent: function() {
        if (this.collection) {
            return this.collection.get(this.get('parent'));
        }
    },
    getChildren: function() {
        if (this.collection) {
            return this.collection.where({parent: this.id});
        }
    },
    getLanguage: function() {
        var idParts;
        if (this.id) {
            idParts = this.id.split("/");
        } else {
            idParts = this.get('parent').split("/");
        }
        return this.collection.get(idParts[0]);
    }
});
