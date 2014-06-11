QUnit.module( "Model.Menu" );
QUnit.test( "test getId", function( assert ) {
    var model = fixtures.menuCollection.get("main-menu/en");

    assert.equal(model.id, "main-menu/en");
});

QUnit.test( "test getChildren", function( assert ) {
    var model = fixtures.menuCollection.get("main-menu/en");
    assert.strictEqual(model.getChildren().length, 3);
});

QUnit.test( "test getParent", function( assert ) {
    var model = fixtures.menuCollection.get("main-menu/en"),
        model2 = fixtures.menuCollection.get("main-menu/en/bundles");
    assert.ok(model2.getParent() instanceof Model.Menu);
    assert.strictEqual(model2.getParent(), model);
});
