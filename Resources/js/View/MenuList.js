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

    }

});