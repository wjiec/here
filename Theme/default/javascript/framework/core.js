/**
 * Blogger Default Framework
 */

// using
new Hee({
    mountPointer: '#headers',
    component: '/component/default/header',
    dataProvider: '/user/profile/@admin'
});


new Hee({
    mountPointer: '#articles',
    component: '/component/default/article',
    dataProvider: '/article/get/new',
    requestParams: {
        limit: 10
    }
});
