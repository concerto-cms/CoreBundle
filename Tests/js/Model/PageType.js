QUnit.module( "Model.PageType" );
QUnit.test( "test id", function( assert ) {
    var model = new Model.PageType({
        name: 'foo'
    });

    assert.equal(model.id, "foo");
});

var FooObject = function(options) {
    this.options = options;
};
QUnit.test( "test createView", function( assert ) {
    var model = new Model.PageType({
        jsView: 'FooObject'
    }),
        view = model.createView({foo: "bar"});
    assert.ok(view instanceof FooObject);
    assert.equal(view.options.foo, "bar");
});
