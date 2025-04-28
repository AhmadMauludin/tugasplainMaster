Routesnya

```
$routes->get('/chatfriend/index/(:num)', 'ChatFriend::index/$1', $user);
$routes->post('/chatfriend/send', 'ChatFriend::send', $user);
$routes->get('/chatgroup/index/(:num)', 'ChatGroup::index/$1', $user);
$routes->post('/chatgroup/send', 'ChatGroup::send', $user);
```

Ini link (untuk button) untuk menuju ke halamannya, pasang di halaman index groups dan friendship

```
<a href="<?= site_url('chatgroup/index/' . $row['id']) ?>">Chat group</a>
<a href="<?= site_url('chatfriend/index/' . $friend['id']) ?>">Chat friend</a>
```
