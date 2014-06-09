QUnit.module( "Model.Menu" );
QUnit.test( "test getId", function( assert ) {
    var model = new Model.Menu({
        id: "/cms/menu/main-menu/en"
    });
    assert.equal(model.getId(), "main-menu/en");
});
