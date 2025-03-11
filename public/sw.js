// Esse Service Worker pode ser aprimorado conforme suas necessidades
self.addEventListener('push', function(event) {
    let data = {};
    if (event.data) {
        data = event.data.json();
    }
    const title = data.title || "Nova Notícia!";
    const options = {
        body: data.content || "Confira as últimas notícias!",
        icon: "/path/to/icon.png"
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    event.waitUntil(clients.openWindow('/'));
});