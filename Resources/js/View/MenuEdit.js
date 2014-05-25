var View = View || {};

View.MenuEdit = Backbone.View.extend({
    initialize: function(options) {
        _.extend(this, options);
        this.originalModel = this.model;
        this.model = this.originalModel.clone();
        this.listenToOnce(this.model, "change", this.onChange);
        this.originalModel.url = Routing.generate('concerto_cms_core_navigation_rest', {path: this.model.getId()});
    },

    render: function() {
        this.$el.children("a").after(window.JST["navigation.menuEdit.html.twig"].render(this));
        this.checkMoveButtons();
        this.stickit();
    },
    events: {
        'click button.move-up': 'moveUp',
        'click button.move-down': 'moveDown',
        'click button.delete': 'removeItem',
        'click button.add': 'addSubmenu',
        "click button.save": "save"
    },
    bindings: {
        '[name=label]': 'label',
        '[name=uri]': 'uri'
    },
    moveUp: function() {
        var container = this.$el,
            prevItem = container.prev();
        prevItem.before(container);
        this.updateOrder(prevItem.data("id"), container.data("id"));
        this.checkMoveButtons();
    },
    moveDown: function() {
        var container = this.$el,
            nextItem = container.next();
        nextItem.after(container);
        this.updateOrder(container.data("id"), nextItem.data("id"));
        this.checkMoveButtons();
    },
    updateOrder: function(first, second) {
        var nextItem = this.$el.next(),
            id = "";

        if (nextItem.length > 0) {
            nextItem.data("id");
        }
        $.ajax
        ({
            type: "PUT",
            url: Routing.generate('concerto_cms_core_navigation_rest', {path: first}),
            dataType: 'json',
            contentType:"application/json; charset=utf-8",
            data: '{"orderBefore": "' + second + '"}'
        });

    },
    remove: function() {
        this.unstickit();
        this.$("form").remove();
    },
    removeItem: function() {
        var that = this;
        $.ajax({
            type: 'DELETE',
            url: Routing.generate('concerto_cms_core_navigation_rest', {path: this.model.getId()}),
            contentType:"application/json; charset=utf-8",
            dataType:"json"
        });
        that.$el.slideUp(function() {
            $(this).remove();
        });


    },

    checkMoveButtons: function() {
        var container = this.$el;
        if (container.prev().length > 0) {
            this.$("button.move-up").removeAttr("disabled").removeClass("disabled");
        } else {
            this.$("button.move-up").attr("disabled", "disabled").addClass("disabled");
        }
        if (container.next().length > 0) {
            this.$("button.move-down").removeAttr("disabled").removeClass("disabled");
        } else {
            this.$("button.move-down").attr("disabled", "disabled").addClass("disabled");
        }
    },
    onChange: function() {
        this.$("button.save").removeAttr("disabled").removeClass("disabled");

    },
    save: function() {
        this.$("button.save").attr("disabled", "disabled").addClass("disabled");
        this.originalModel.set(this.model.attributes).save();
        this.listenToOnce(this.model, "change", this.onChange);
    },
    addSubmenu: function() {
        var model = new Model.Menu({
            parent: this.model.id
        }),
            view = new View.NewMenuDialog({
                model: model
            });
        model.url = Routing.generate('concerto_cms_core_navigation_rest', {path: this.model.getId()});
        model.once("change:id", this.trigger("add"));
    }
});