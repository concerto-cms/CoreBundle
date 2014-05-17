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
    getId: function() {
        return this.get('id').replace("/cms/pages/", "");
    }
})