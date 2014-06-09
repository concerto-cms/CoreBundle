var Model = Model || {};

Model.Page = Backbone.Model.extend({
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
        var idParts = this.id.split("/");
        return this.collection.get(idParts[0]);
    }
});
