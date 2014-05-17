var Controller = Controller || {};

Controller.News = function(options) {
    var that = this,
        router;

    this.views = [];
    this.news = new Collection.News(options.news);
    this.newsContainer = document.getElementById("newsContainer");

    // Setup router
    _.bindAll(this, "listAction", "editAction", "newAction");
    router = Backbone.Router.extend({
        routes: {
            "":             "list",
            "edit/:item":   "edit",
            "new":          "new"
        },
        list: this.listAction,
        edit: this.editAction,
        new: this.newAction

    });
    this.router = new router();
    Backbone.history.start()
};
_.extend(Controller.News.prototype, Backbone.Events);
_.extend(Controller.News.prototype, {
    cleanup: function() {
        _.each(this.views, function(view) {
            view.remove();
        });
        this.views = [];
    },
    listAction: function() {
        var view = new View.NewsList({
                news: this.news
            });
        this.cleanup();
        $(this.newsContainer)
            .append(view.$el);
        this.views.push(view);
    },
    editAction: function(item) {
        var view = new View.NewsItem({
            model: this.news.findWhere({slug: item}),
            collection: this.news
        });
        this.cleanup();
        $(this.newsContainer)
            .append(view.$el);
        this.views.push(view);
    },
    newAction: function() {
        var view = new View.NewsItem({
            model: new Model.Page({
                date: moment().format("DD-MM-YYYY"),
                publishStart: moment().format("DD-MM-YYYY"),
                publishStop: moment().format("DD-MM-YYYY")
            }),
            collection: this.news
        });
        this.cleanup();
        $(this.newsContainer)
            .append(view.$el);
        this.views.push(view);
    }
});