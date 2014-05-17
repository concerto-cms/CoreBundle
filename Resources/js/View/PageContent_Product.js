var View = View || {};

View.PageContent_Product = Backbone.View.extend({
    initialize: function(options) {
        this.original_model = options.page;
        this.model = new Model.Product(options.page.toJSON());
        this.language = options.language;
        this.route = options.route;
        this.original_model.url = Routing.generate('concerto_cms_core_content_rest', {path: this.model.getId()});

        _.bindAll(this, "render");
        this.render();
        this.listenToOnce(this.model, "change", this.onChange);

    },

    bindings: {
        '#content_title': 'title',
        '#content_content': 'content'
    },

    render: function() {
        var editor,
            that = this;
        this.el.innerHTML = window.JST["content.productContent.html.twig"].render(this);
        editor = this.$("#content_content").ckeditor().data("ckeditorInstance");
        editor.on( 'change', function(e) {
            that.$("#content_content").trigger("change");
        });

        setTimeout(function() {
            that.uploader = new qq.FineUploaderBasic({
                button: document.getElementById("uploadBrochure"),
                request: {
                    endpoint: Routing.generate('betec_backend_content_rest_save_productbrochure', {path: that.model.getId()})
                },
                acceptFiles: 'application/pdf',
                callbacks: {
                    onComplete: function(success, filename, data) {
                        that.model.set('brochure', data.brochure);
                        that.render();
                    }
                }
            });

        }, 50);
        this.stickit();
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
    },


});