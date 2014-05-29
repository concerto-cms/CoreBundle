var Model = Model || {};

Model.PageType = Backbone.Model.extend({
    defaults: {
    },
    idAttribute: 'name',
    initialize: function() {
    },

    createView: function(options) {
        var view = eval(this.get('jsView'));
        return new view(options);
    },

    isAllowed: function(type) {
        var allowed = this.get('allowedChildTypes');
        if (allowed === null) {
            return type.get('showInList');
        }
        return (_.indexOf(allowed, type.id) >= 0);
    },

    allowChildren: function() {
        var allowed = this.get('allowedChildTypes');
        return (allowed === null || allowed.length > 0);
    }

});