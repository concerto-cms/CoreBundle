QUnit.module( "Collection.Menus" );

var fixtures = fixtures || {};
fixtures.menuCollection = new Collection.Menus([
        {
            "id":"/cms/menu/main-menu",
            "name":"main-menu",
            "label":"Main menu",
            "parent":"/cms/menu",
            "uri":null
        },
        {
            "id":"/cms/menu/main-menu/en",
            "name":"en",
            "label":"English",
            "parent":"/cms/menu/main-menu",
            "uri":null
        },
        {
            "id":"/cms/menu/main-menu/en/bundles",
            "name":"bundles",
            "label":"Bundles",
            "parent":"/cms/menu/main-menu/en",
            "uri":"en/bundles"
        },
        {
            "id":"/cms/menu/main-menu/en/docs",
            "name":"docs",
            "label":"Documentation",
            "parent":"/cms/menu/main-menu/en",
            "uri":"en/docs"
        },
        {
            "id":"/cms/menu/main-menu/en/docs/cookbook",
            "name":"cookbook",
            "label":"cookbook",
            "parent":"/cms/menu/main-menu/en/docs",
            "uri":null
        },
        {
            "id":"/cms/menu/main-menu/en/docs/cookbook/create_new_pagetypes",
            "name":"create_new_pagetypes",
            "label":"create_new_pagetypes",
            "parent":"/cms/menu/main-menu/en/docs/cookbook",
            "uri":"en/docs/cookbook/create_new_pagetypes"
        },
        {
            "id":"/cms/menu/main-menu/en/docs/getting-started",
            "name":"getting-started",
            "label":"getting-started",
            "parent":"/cms/menu/main-menu/en/docs",
            "uri":null
        },
        {
            "id":"/cms/menu/main-menu/en/docs/getting-started/standard-edition",
            "name":"standard-edition",
            "label":"standard-edition",
            "parent":"/cms/menu/main-menu/en/docs/getting-started",
            "uri":"en/docs/getting-started/standard-edition"
        },
        {
            "id":"/cms/menu/main-menu/en/contribute",
            "name":"contribute",
            "label":"Contribute",
            "parent":"/cms/menu/main-menu/en",
            "uri":"en/contribute"
        }
    ])


QUnit.test( "test getMenus", function( assert ) {
    assert.strictEqual(fixtures.menuCollection.getMenus().length, 1);
});
QUnit.test( "test getMenu", function( assert ) {
    assert.ok(fixtures.menuCollection.getMenu("main-menu", "en") instanceof Model.Menu);
    assert.ok(typeof fixtures.menuCollection.getMenu("nonexisting", "en") === "undefined");
});