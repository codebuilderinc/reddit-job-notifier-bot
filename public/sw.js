self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        window.location = "/error";
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        console.log(msg)
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            actions: msg.actions,
            vibrate: [500,110,500,110,450,110,200,110,170,40,450,110,200,110,170,40,500]
        }));
    }
});


self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  event.waitUntil(
    clients.openWindow("https://jobbit.codebuilder.us/jobs")
  );})

    //event.data.url + "?notification_id=" + event.data.id

