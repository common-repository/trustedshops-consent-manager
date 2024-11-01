window.onload = function() {
    let RssFeed = new RSS(document.querySelector("#rss-feeds"), "https://www.walkenewmedia.de/feed/", {
        layoutTemplate: "<ul>{entries}</ul>",
        entryTemplate: "<li><a class='title' href='{url}'>{title}</a></li>",
        support: false,
        ssl: true
    });
    RssFeed.on('data', (data) => {
        document.querySelector("#rss-feeds span.loading").setAttribute("style", "display:none;");
    })
    RssFeed.render();
};