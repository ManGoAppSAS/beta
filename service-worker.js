'use strict';

/* eslint-env browser, serviceworker */

importScripts('./scripts/libs/idb-keyval.js');
importScripts('./scripts/analytics-sw.js');

self.analytics.trackingId = 'UA-77119321-2';

self.addEventListener('push', function(event) {
  console.log('Received push');
  let notificationTitle = 'Notificación';
  const notificationOptions = {
    body: 'Notificación nueva.',
    icon: './img/a1.jpg',
    badge: './img/a1.jpg',
    tag: 'simple-push-demo-notification',
    data: {
      url: 'index.php',
    },
  };

  if (event.data) {
    const dataText = event.data.text();
    notificationTitle = 'Received Payload';
    notificationOptions.body = `Push data: '${dataText}'`;
  }

  event.waitUntil(
    Promise.all([
      self.registration.showNotification(
        notificationTitle, notificationOptions),
      self.analytics.trackEvent('push-received'),
    ])
  );
});

self.addEventListener('notificationclick', function(event) {
  event.notification.close();

  let clickResponsePromise = Promise.resolve();
  if (event.notification.data && event.notification.data.url) {
    clickResponsePromise = clients.openWindow(event.notification.data.url);
  }

  event.waitUntil(
    Promise.all([
      clickResponsePromise,
      self.analytics.trackEvent('notification-click'),
    ])
  );
});

self.addEventListener('notificationclose', function(event) {
  event.waitUntil(
    Promise.all([
      self.analytics.trackEvent('notification-close'),
    ])
  );
});
