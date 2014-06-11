var Controller = Controller || {};

Controller.Menu = function(options) {
    var that = this,
        router;

    this.views = [];
    this.menus = new Collection.Menus(options.menus);
    this.languages = new Collection.Routes(options.languages);
    this.menuContainer = document.getElementById("navigationContainer");

    this.listenTo(this.menus, "add", this.onAddMenu);

    // Setup router
    _.bindAll(this, "indexAction", "listAction", "editAction")
    router = Backbone.Router.extend({
        routes: {
            "":                     "index",
            ":menu/:language":      "list",
            ":menu/:language/*id":  "edit"
        },
        list: this.listAction,
        edit: this.editAction,
        index: this.indexAction
    });
    this.router = new router();

    Backbone.history.start()
};
_.extend(Controller.Menu.prototype, Backbone.Events);
_.extend(Controller.Menu.prototype, {
    indexAction: function() {
        var language = this.languages.first().get('name'),
            menu = _.first(this.menus.getMenus()).get('name');
        if (!menu) {
            // @todo show an error page saying there are no menus
            alert("No menus");
        } else if (!language) {
            // @todo show an error page saying there are no languages
            alert("No languages");
        } else {
            this.router.navigate(menu + "/" + language, {trigger: true});
        }
    },
    listAction: function(menu, language) {
        var model = this.menus.getMenu(menu, language),
            view = new View.MenuList({
                model: model,
                menus: this.menus,
                languages: this.languages,
                language: language
            });
        this.cleanup();
        $(this.menuContainer)
            .append(view.$el);
        this.views.push(view);

    },
    editAction: function(menu, language, id) {
        var model = this.menus.get(menu + "/" + language + "/" + id),
            container;
        if (!(this.views[0] instanceof View.MenuList)) {
            this.listAction(menu, language);
        }
        container = this.views[0].$('[data-id="' + menu + "/" + language + "/" + id + '"]');
        this.views[0].$(".item-list li.active").removeClass("active");
        container.addClass("active");

        if (typeof this.editView !== "undefined") {
            this.editView.remove();
        }
        this.editView = new View.MenuEdit({
            model: model,
            el: container[0],
            collection: this.menus
        });
        this.listenTo(this.editView, "add", this.render);
        this.editView.render();
    },
    cleanup: function() {
        var that = this;
        _.each(this.views, function(view) {
            that.stopListening(view);
            view.remove();
        });
        this.views = [];
    },
    onAddPage: function(page) {
        this.router.navigate(page.getLanguage().get('name') + "/" + page.getId(), {trigger: true});
    }
});