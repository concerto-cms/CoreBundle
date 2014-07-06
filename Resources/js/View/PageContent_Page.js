var View = View || {};

View.PageContent_Page = Backbone.View.extend({
    initialize: function(options) {
        this.model = options.model;
        this.language = options.language;
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
        this.el.innerHTML = window.JST["content.pageContent.html.twig"].render({
            page: this.model,
            language: this.language
        });
        editor = this.$("#content_content").ckeditor({
            customConfig: ''
        }).data("ckeditorInstance");
        editor.on( 'change', function(e) {
            that.$("#content_content").trigger("change");
        });
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
        this.trigger("save");
        this.listenToOnce(this.model, "change", this.onChange);
    }
});