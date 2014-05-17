var View = View || {};

View.NewMenuDialog = Backbone.View.extend({
    initialize: function(options) {
        var that = this;
        _.extend(this, options);
        this.render();
    },

    className: 'modal fade',
    render: function() {
        this.el.innerHTML = window.JST["navigation.newmenuDialog.html.twig"].render(this);
        this.$el.appendTo("body");
        this.$el.modal();
        this.stickit();
    },
    events: {
        'click button.save': 'save'
    },
    bindings: {
        '[name=label]': 'label',
        '[name=uri]': 'uri'
    },
    save: function() {
        var that = this
        this.$("button").attr("disabled", "disabled").addClass("disabled");


        this.model.once("change:id", function() {
            that.collection.add(this);
            that.$el.modal('hide');
            $.growl({
                title: 'De pagina is toegevoegd',
                icon: 'glyphicon glyphicon-saved'
            },{ type: 'success' });

            that.remove();
        })
        this.model.save();
    },

    updatePageTypes: function() {

    }
});