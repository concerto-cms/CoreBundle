var Model = Model || {};

Model.Product = Backbone.Model.extend({
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
    },

    getBrochure: function() {
        if (this.has('brochure')) {
            return Routing.generate('betec_website_brochure', {path: this.getId()});
        } else {
            return null;
        }
    }
})