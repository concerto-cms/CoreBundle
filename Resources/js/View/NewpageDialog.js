var View = View || {};

View.NewpageDialog = Backbone.View.extend({
    initialize: function(options) {
        var that = this;
        _.extend(this, options);

        this.model = new Model.Page({
            type: this.pageTypes.first().id,
            parent: this.current.id
        });

        //this.listenTo(this.model, "change:parent", this.render);
        this.parentList = [this.current];
        this.populateParents(this.current);
        this.render();
    },

    className: 'modal fade',
    render: function() {
        this.el.innerHTML = window.JST["content.newpageDialog.html.twig"].render(this);
        this.$el.appendTo("body");
        this.$el.modal();
        this.populatePageTypes();
        this.stickit();
        this.$("[name=type]").trigger("change");
//        this.$("input, select").trigger("change");

    },
    events: {
        'click button.save': 'save'
    },
    bindings: {
        '[name=type]': 'type',
        '[name=parent]': 'parent',
        '[name=name]': 'slug'
    },

    populateParents: function(item) {
        var that = this;
        _.each(item.getChildren(), function(route) {
            var id = route.id,
                idParts = _.rest(id.split("/")),
                label = idParts.join(" / ");
            that.parentList.push(route);
            that.populateParents(route);

        })
    },
    getPageTypes: function() {
        var parentId = this.model.get('parent'),
            parentPage = this.pages.get(parentId),
            parentType = this.pageTypes.get(parentPage.get('type'));

        return this.pageTypes.getList(parentType);
    },
    populatePageTypes: function() {
        console.dir(this.getPageTypes());
    },
    save: function() {
        var that = this;
        this.$("button").attr("disabled", "disabled").addClass("disabled");
        this.model.once("change:id", function() {
            that.current.collection.add(this);
            that.$el.modal('hide');
            that.remove();
        })
        this.model.save();
    },

    updatePageTypes: function() {

    }
});