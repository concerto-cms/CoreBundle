var View = View || {};

View.MenuList = Backbone.View.extend({
    initialize: function(options) {
        _.extend(this, options);
        this.render();
    },

    render: function() {
        this.el.innerHTML = window.JST["navigation.menuList.html.twig"].render(this);
    },
    events: {
        "click button.new-menu": "newMenu"
    },

    newMenu: function() {
        console.log("new menu");
        var model = new Model.Menu({
                parent: this.model.id
            }),
            view = new View.NewMenuDialog({
                model: model
            });
        model.url = Routing.generate('concerto_cms_core_navigation_rest', {path: this.model.id});
        model.once("change:id", this.trigger("add"));
    }

});