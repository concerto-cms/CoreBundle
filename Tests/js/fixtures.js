var fixtures = fixtures || {};
fixtures.menuCollection = new Collection.Menus([{"id":"main-menu","name":"main-menu","label":"Main menu","parent":"","uri":null},{"id":"main-menu\/en","name":"en","label":"English","parent":"main-menu","uri":null},{"id":"main-menu\/en\/bundles","name":"bundles","label":"Bundles","parent":"main-menu\/en","uri":"en\/bundles"},{"id":"main-menu\/en\/docs","name":"docs","label":"Documentation","parent":"main-menu\/en","uri":"en\/docs"},{"id":"main-menu\/en\/docs\/cookbook","name":"cookbook","label":"cookbook","parent":"main-menu\/en\/docs","uri":null},{"id":"main-menu\/en\/docs\/cookbook\/create_new_pagetypes","name":"create_new_pagetypes","label":"create_new_pagetypes","parent":"main-menu\/en\/docs\/cookbook","uri":"en\/docs\/cookbook\/create_new_pagetypes"},{"id":"main-menu\/en\/docs\/getting-started","name":"getting-started","label":"getting-started","parent":"main-menu\/en\/docs","uri":null},{"id":"main-menu\/en\/docs\/getting-started\/standard-edition","name":"standard-edition","label":"standard-edition","parent":"main-menu\/en\/docs\/getting-started","uri":"en\/docs\/getting-started\/standard-edition"},{"id":"main-menu\/en\/contribute","name":"contribute","label":"Contribute","parent":"main-menu\/en","uri":"en\/contribute"}])

fixtures.pageCollection = new Collection.Pages([
    {
        "id":"en",
        "title":"Concerto CMS, an opensource CMS based on Symfony CMF",
        "slug":"en",
        "description":null,
        "content":"<p>Concerto CMS is an opensource CMS that puts together many great opensource projects:</p>",
        "type":"ConcertoCmsCoreBundle:Page",
        "parent":"",
        "language":{
            "name":"English",
            "prefix":"en",
            "isoCode":"en-UK"
        }
    },
    {
        "id":"en/bundles",
        "title":"Meet the Concerto bundle family!",
        "slug":"bundles",
        "description":null,
        "content":"<h1>Meet the Concerto bundle family!</h1>",
        "type":"ConcertoCmsCoreBundle:Page",
        "parent":"en"
    },
    {
        "id":"en/docs",
        "title":"Documentation",
        "slug":"docs",
        "description":null,
        "content":"<p>Coming soon!</p>",
        "type":"ConcertoCmsCoreBundle:Page",
        "parent":"en"
    },
    {
        "id":"en/contribute",
        "title":"Contribute (or get help)",
        "slug":"contribute",
        "description":null,
        "content":"<h1>Contribute (or get help)</h1>",
        "type":"ConcertoCmsCoreBundle:Page",
        "parent":"en"
    }
])