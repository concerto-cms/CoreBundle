QUnit.module( "Model.Page" );
QUnit.test( "test getParent", function( assert ) {
    var model = fixtures.pageCollection.get("en"),
        model2 = fixtures.pageCollection.get("en/bundles");
    assert.ok(model2.getParent() instanceof Model.Page);
    assert.strictEqual(model2.getParent(), model);
});

QUnit.test( "test getChildren", function( assert ) {
    var model = fixtures.pageCollection.get("en");
    assert.strictEqual(model.getChildren().length, 3);
});

QUnit.test( "test getLanguage", function( assert ) {
    var model = fixtures.pageCollection.get('en/docs');
    assert.equal(model.getLanguage(), fixtures.pageCollection.get('en'));
});

QUnit.test( "test language model", function( assert ) {
    var model = fixtures.pageCollection.get('en');
    assert.ok(model.has('language'));
    assert.equal(
        _.keys(model.get('language')).toString(),
        'name,prefix,isoCode'
    );
});

