QUnit.module( "Collection.Menus" );
QUnit.test( "test getMenus", function( assert ) {
    assert.strictEqual(fixtures.menuCollection.getMenus().length, 1);
});
QUnit.test( "test getMenu", function( assert ) {
    assert.ok(fixtures.menuCollection.getMenu("main-menu", "en") instanceof Model.Menu);
    assert.ok(typeof fixtures.menuCollection.getMenu("nonexisting", "en") === "undefined");
});