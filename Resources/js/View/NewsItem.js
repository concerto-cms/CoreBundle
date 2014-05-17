var View = View || {};

View.NewsItem = Backbone.View.extend({
    initialize: function(options) {
        var that = this;
        _.extend(this, options);
        this.original_model = options.model;
        this.model = options.model.clone();
        if (options.model.has('id')) {
            this.original_model.url = Routing.generate('concerto_cms_core_content_rest', {path: this.model.getId()});
        } else {
            this.original_model.url = Routing.generate('concerto_cms_core_content_rest', {path: 'en/news'});
        }

        this.listenTo(this.original_model, "change:id", function() {
            this.collection.add(this.original_model);
            this.model = this.original_model.clone();
            /*
            $.growl({
                title: 'Het nieuwsitem is toegevoegd',
                icon: 'glyphicon glyphicon-saved'
            },{ type: 'success' });
            */
        });
        this.listenTo(this.original_model, "sync", this.render);

        this.render();
        this.listenToOnce(this.model, "change", this.onChange);
    },

    bindings: {
        '#news_content':        'content',
        '#news_introduction':   'introduction',
        '[name=date]':          {
            observe: 'date'
        },
        '[name=publishStart]':  'publishStart',
        '[name=publishStop]':   'publishStop',
        '[name=title]':         'title'
    },

    render: function() {
        var editor1, editor2,
            that = this;
        this.el.innerHTML = window.JST["news.item.html.twig"].render(this);
        editor1 = this.$("#news_introduction").ckeditor().data("ckeditorInstance");
        editor1.on( 'change', function(e) {
            that.$("#news_introduction").trigger("change");
        });
        editor2 = this.$("#news_content").ckeditor().data("ckeditorInstance");
        editor2.on( 'change', function(e) {
            that.$("#news_content").trigger("change");
        });
        this.stickit();
        this.$("input.datepicker").datepicker({
            format: "dd-mm-yyyy"
        });

    },
    events: {
        "click button.save": "save"
    },
    onChange: function() {
        this.$("button.save").removeAttr("disabled").removeClass("disabled");

    },
    save: function() {
        this.$("button.save").attr("disabled", "disabled").addClass("disabled");
        this.original_model.set(this.model.attributes).save();
        this.listenToOnce(this.model, "change", this.onChange);
    }

});