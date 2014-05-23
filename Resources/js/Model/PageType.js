var Model = Model || {};

Model.PageType = Backbone.Model.extend({
    defaults: {
        showInList: true,
        allowChildPageTypes: null,
        createRoute: 'betec_backend_content_rest_new_page'
    },
    initialize: function() {
    },

    createView: function(options) {
        var view = eval(this.get('view'));
        return new view(options);
    },

    isAllowed: function(type) {
        var allowed = this.get('allowChildPageTypes');
        if (allowed === null) {
            return type.get('showInList');
        }
        return (_.indexOf(allowed, type.id) >= 0);
    },

    allowChildren: function() {
        var allowed = this.get('allowChildPageTypes');
        return (allowed === null || allowed.length > 0);
    }

});