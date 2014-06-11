QUnit.module( "Collection.Pages" );
QUnit.test( "test getLanguages", function( assert ) {
    var languages = fixtures.menuCollection.getMenus();
    assert.strictEqual(languages.length, 1);
    assert.ok(languages[0] instanceof Model.Menu);
});
